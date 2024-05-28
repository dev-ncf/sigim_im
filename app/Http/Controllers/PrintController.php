<?php

namespace App\Http\Controllers;

use App\Models\MovementStudent;
use App\Models\StudentEnrollment;
use App\Models\Student;
use Dompdf\Dompdf;
use phputil\extenso\Extenso;
use Illuminate\Http\Request;

class PrintController extends Controller
{


    public function receiptPayment($number)
    {
        function obterNomeMes($semestre) {
    switch ($semestre) {
        case 1:
            return 'Janeiro';
        case 2:
            return 'Fevereiro';
        case 3:
            return 'Março';
        case 4:
            return 'Abril';
        case 5:
            return 'Maio';
        case 6:
            return 'Junho';
        case 7:
            return 'Julho';
        case 8:
            return 'Agosto';
        case 9:
            return 'Setembro';
        case 10:
            return 'Outubro';
        case 11:
            return 'Novembro';
        case 12:
            return 'Dezembro';
        default:
            return 'Mês Inválido';
    }
}
        $movement = MovementStudent::with(['payment', 'items', 'student'])->where('code', '=', $number)->first();

        $payment = $movement->payment;
        $items = $movement->items;

        $student = $movement->student;
        $enrollment = $student->studentEnrollment;
        $course = $student->studentEnrollment->course->label;

        $total = number_format($movement->total_amount, 2, '.', ',');

        $e = new Extenso();

        $e = str_replace(['real', 'reais'], ['metical', 'meticais'], $e->extenso($movement->total_amount));

        $manager = auth()->user()->first_name.' '. auth()->user()->last_name;
        $date = date('Y-m-d H:i:s');
        $mes= obterNomeMes($movement->month);
        $str_items = '';

        $order = 0;
        foreach ($items as $item) {
    $amount = number_format($item->amount, 2, '.', ',');



    // Verifica se o item não é a taxa de matrícula
    if($movement->semestre>1){

        if ($item->description !== 'Taxa de Matrícula (Nacional)' && $item->description !== 'Taxa de Matrícula (Estrangeiro)') {
            $order = $order + 1;
            $str_items = $str_items . "
                <tr>
                    <td>$order</td>
                    <td>$item->description</td>
                    <td>
                        $amount
                    </td>
                </tr>
            ";
        }
    }else{
        $order = $order + 1;
         $str_items = $str_items . "
                <tr>
                    <td>$order</td>
                    <td>$item->description</td>
                    <td>
                        $amount
                    </td>
                </tr>
            ";

    }
}


        $str = <<<TEXT
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Comprovativo de Pagamento</title>
                    <style type="text/css">
                        *{
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                            font-weight: 400;
                            font-size: 12pt;
                        }
                        .recepient-header{
                            margin-top: 20px;
                            margin-bottom: 20px;
                            width: 100%;
                            text-align: center;
                        }

                        .recepient-header h1, h2{
                            font-size: 10pt;
                            font-weight: 600;
                        }

                        .recepient-header h1, h2{
                            line-height: 20px;
                        }

                        .recepient-body{
                            width: 100%;
                            display: flex;
                            justify-content: space-between;
                            align-items: centers;
                            margin-bottom: 5px;
                            flex-wrap: wrap;
                        }

                        .recepient-body h4{
                            font-size: 10pt;
                            line-height: 23px;
                        }

                        /* Estilizando a tabela */
                        table, th, td{
                            border: 1px solid #000000;
                            text-align: center;
                            font-size: 8pt;
                            border-collapse: collapse;
                        }

                        th{
                            font-weight: 600;
                        }

                        img{
                            border-radius: 50%;
                        }

                        li{
                            font-size: 9pt;
                            text-align: justify;
                        }

                    </style>
                </head>
                <body style="padding: 0 100px">
                    <br>
                    <div class="recepient-header">
                        <img src="https://sigim.co.mz/img/logo.jpg" style="width: 70px;">
                        <h1>Universidade Rovuma</h1>
                        <h2>Direcção do Registo Académico</h2>
                        <h2>Comprovativo de Pagamento</h2>
                    </div>
                    <div style="width: 100%; border-top: 1px solid #000000;"></div>
                    <div class="recepient-body">
                        <div style="width: 100%; margin-top: 10px;">
                            <div style="float: left;">
                                <p style="font-weight: 400 !important; margin-bottom: 5px; font-size: 8pt;">Recibo numero: <span style="font-size: 8pt; font-weight: 600;">$movement->code</span></p>
                            </div>
                            <div style="float: right;">
                                <p style="font-weight: 400 !important; margin-bottom: 5px; font-size: 8pt;">Emitido em: <span style="font-size: 8pt; font-weight: 600;">$movement->created_at</span></p>
                            </div><br>
                            <div style="width: 100%; margin-top: 5px; margin-bottom: 5px;">
                                <span style="font-size: 10pt;">Estudante: </span>
                                <span style="font-size: 10pt; border: 1px solid #000000; font-weight: 700; padding: 1px;">$student->first_name $student->last_name</span>
                                <span style="font-size: 10pt; margin-left: 20px;">Codigo de estudante: <span style="font-size: 8pt; font-weight: 600;">$student->code</span></span><br>
                                <span style="font-size: 10pt; line-height: 25px;">Curso: <span style="font-size: 8pt; font-weight: 600;">$course <span style="font-size: 8pt; font-weight: normal; margin-left:280px">Semestre: <span style="font-size: 8pt; font-weight: bolder;">$movement->semestre</span>º</span></span>
                            </div>
                            <table style="width: 100%;">
                                <tr>
                                    <th>Montante (MT)</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Numero de Talão</th>
                                    <th>Data do deposito</th>
                                    <th>Conta</th>
                                </tr>
                                <tr>
                                    <td>$total</td>
                                    <td>
                                        $payment->label
                                    </td>
                                    <td>
                                        $movement->receipt_number
                                    </td>
                                    <td>
                                        $movement->date_receipt
                                    </td>
                                    <td>
                                        475827778-BIM
                                    </td>
                                </tr>
                            </table>
                            <span style="font-size: 8pt; font-weight: 800; line-height: 30px;">Extenso: $e.</span>
                        </div>

                        <div style="width: 100%; margin-top: 15px;">
                        <span style="font-size: 10pt; font-weight: 800;">Mês de $mes</span>
                            <table style="width: 100%;">
                                <tr>
                                    <th>Ordem</th>
                                    <th>Referente a:</th>
                                    <th>Montante (MT)</th>
                                </tr>
                                $str_items
                            </table>
                            <div style="margin-top: 20px; width: 100%;">
                                <h4 style="font-size: 7pt; float: left; font-weight: 600;">Impresso no dia: $date</h4>
                            </div>
                            <div style="margin-top: 30px; width: 100%; padding-right: 50px;">
                                <div style="width: 300px; border-top: 1px solid #000000; float: right;"></div><br>
                                <h4 style="font-size: 7pt; float: right; margin-right: 110px; font-weight: 600;">$manager</h4>
                            </div>
                        </div>
                    </div>

                    <div style="width: 100%; left: 0; top: 20; padding: 0 0 15px 0;">
                        <span style="font-style: italic; font-size: 7pt; font-weight: 400;">Processado por SIGIM<sub style="font-size: 8pt;">v1.2.0-beta</sub></span>
                    </div>

                    <br>
                        <div style="border-top: 1px solid #000000; border-top-style: dashed; position: absolute; width: 100%; left:0;"></div>
                    <br><br>
                    <div class="recepient-header">
                        <img src="https://sigim.co.mz/img/logo.jpg" style="width: 70px;">
                        <h1>Universidade Rovuma</h1>
                        <h2>Direcção do Registo Académico</h2>
                        <h2>Comprovativo de Pagamento</h2>
                    </div>
                    <div style="width: 100%; border-top: 1px solid #000000;"></div>
                    <div class="recepient-body">
                        <div style="width: 100%; margin-top: 10px;">
                            <div style="float: left;">
                                <p style="font-weight: 400 !important; margin-bottom: 5px; font-size: 8pt;">Recibo numero: <span style="font-size: 8pt; font-weight: 600;">$movement->code</span></p>
                            </div>
                            <div style="float: right;">
                                <p style="font-weight: 400 !important; margin-bottom: 5px; font-size: 8pt;">Emitido em: <span style="font-size: 8pt; font-weight: 600;">$movement->created_at</span></p>
                            </div><br>
                            <div style="width: 100%; margin-top: 5px; margin-bottom: 5px;">
                                <span style="font-size: 10pt;">Estudante: </span>
                                <span style="font-size: 10pt; border: 1px solid #000000; font-weight: 700; padding: 1px;">$student->first_name $student->last_name</span>
                                <span style="font-size: 10pt; margin-left: 20px;">Codigo de estudante: <span style="font-size: 8pt; font-weight: 600;">$student->code</span></span><br>
                                <span style="font-size: 10pt; line-height: 25px;">Curso: <span style="font-size: 8pt; font-weight: 600;">$course</span><span style="font-size: 8pt; font-weight: normal; margin-left:280px">Semestre: <span style="font-size: 8pt; font-weight: bolder;">$movement->semestre</span>º <span></span>
                            </div>
                            <table style="width: 100%;">
                                <tr>
                                    <th>Montante (MT)</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Numero de Talão</th>
                                    <th>Data do deposito</th>
                                    <th>Conta</th>
                                </tr>
                                <tr>
                                    <td>$total</td>
                                    <td>
                                        $payment->label
                                    </td>
                                    <td>
                                        $movement->receipt_number
                                    </td>
                                    <td>
                                        $movement->date_receipt
                                    </td>
                                    <td>
                                        475827778-BIM
                                    </td>
                                </tr>
                            </table>
                            <span style="font-size: 8pt; font-weight: 800; line-height: 30px;">Extenso: $e.</span>
                        </div>

                        <div style="width: 100%; margin-top: 15px;">
                        <span style="font-size: 10pt; font-weight: 800;">Mês de $mes</span>
                            <table style="width: 100%;">
                                <tr>
                                    <th>Ordem</th>
                                    <th>Referente a:</th>
                                    <th>Montante (MT)</th>
                                </tr>
                                $str_items
                            </table>
                            <div style="margin-top: 20px; width: 100%;">
                                <h4 style="font-size: 7pt; float: left; font-weight: 600;">Impresso no dia: $date</h4>
                            </div>
                            <div style="margin-top: 30px; width: 100%; padding-right: 50px;">
                                <div style="width: 300px; border-top: 1px solid #000000; float: right;"></div><br>
                                <h4 style="font-size: 7pt; float: right; margin-right: 110px; font-weight: 600;">$manager</h4>
                            </div>
                        </div>
                    </div>
                    <div style="width: 100%; left: 0; top: 10; padding: 0 0 15px 0;">
                        <span style="font-style: italic; font-size: 7pt; font-weight: 400;">Processado por SIGIM<sub style="font-size: 8pt;">v1.2.0-beta</sub></span>
                    </div>
                </body>
            </html>
        TEXT;

        $pdf = new Dompdf(["enable_remote" => true]);

        ob_start();
            echo $str;
        $data = ob_get_clean();

        $pdf->loadHtml($data);
        $pdf->setPaper('A4');
        $pdf->render();
        $pdf->stream();
    }

    //A funcao que executa a impressao dos recibos
    public function print($code,$id){
        $student_data = Student::with(['studentEnrollment', 'manager'])->where('code', '=', $code)->first();
        $enrollment = StudentEnrollment::with(['student','faculty'])
        ->where('student_id','=',$student_data->id)
        ->where('id','=',$id)->first();

        if ($student_data) {
            $pdf = new Dompdf(["enable_remote" => true]);
            if($enrollment->enrollment_status == 2){
                $printer = $this->printerApproved($enrollment);
            }elseif($enrollment->enrollment_status == 1){
                $printer = $this->printerPending($enrollment);
            }
            ob_start();
                //echo printerPending($student_data);
                echo $printer;
            $data = ob_get_clean();

            $pdf->loadHtml($data);
            $pdf->setPaper('A4');
            $pdf->render();
            $pdf->stream();
        }
    }

    //Funcoes para imprimir recibos de inscricao
    private function printerPending($enrollment){
          if ($enrollment->enrollment_status == 1) {
            $status = "Pendente";
        }elseif ($enrollment->enrollment_status== 2) {
            $status = "Aprovada";
        }elseif($enrollment->enrollment_status== 0){
            $status = "Cancelada";
        }
        $taxaMatricula = "Taxa de matrícula;";
        $primeiraPropinaMensal = "e a primeira propina mensal";
        if($enrollment->semestre >1){
            $taxaMatricula = "";
            $primeiraPropinaMensal="";
        }

        $data = date('d-m-Y H:i:s');
        $faculty = $enrollment->faculty->label;
        $course = $enrollment->course->label;
        $sewing = $enrollment->sewingLine->label;
        $student = $enrollment->student;
        $str_itemsPre='';
        $taxaPorDisciplinas = ($enrollment->taxa) * ($enrollment->numero_disciplinas);
        if($enrollment->semestre>1){
        $taxaLabel = "Taxa de inscrição por disciplina ( $enrollment->numero_disciplinas x $enrollment->taxa,00)";
        $str_itemsPre = $str_itemsPre."
        <div style='margin-top: 5px;'>
                                <table style='width: 100%;'>
                                <tr>
                                    <th>Ordem</th>
                                    <th>Referente a:</th>
                                    <th>Montante (MT)</th>
                                </tr>
                                <tr>
                                <tr>
                                <td>2</td>
                                <td>$taxaLabel</td>
                                <td>$taxaPorDisciplinas,00</td>

                                </tr>

                                </table>
                                 <div style='margin-left: 453px;border: 1px solid; border-top:none; align-items:center; text-align: center; margin-bottom:20px;'>

                                    <strong>Total</strong>
                                    <strong>$enrollment->valor,00</strong>
                                </div>
                                <p><span style='font-weight: 500; '>Nota:</span> Para que a sua pré-inscrição seja aprovada, siga os seguintes passos: </p>

                                <ul style='margin-left: 40px; padding: 5px;'>
                                    <li>Faça o pagamento das taxas através de um depósito Bancário no  Millenium BIM, na conta numero: 475827778 - NIB 000100000047582777857 - Universidade Rovuma;</li><br>
                                    <li>Após o depósito, dirigir-se à Direcção do Registo Académico em Nampula ou aos Departamentos de Registo Académico dos Institutos(Lichinga e Montepuez) com o talão de depósito e a ficha impressa de pré-inscrição.</li>

                             </ul>
             </div>
        ";
    }else{
        $str_itemsPre = $str_itemsPre."

        <div style='margin-top: 5px;'>
            <p><span style='font-weight: 500;'>Nota:</span> Para que a sua inscrição seja aprovada, siga os sequintes passos: </p>

            <ul style='margin-left: 40px; padding: 5px;'>
                <li>Faça o pagamento das taxas ($taxaMatricula Inscrição semestral por disciplina / módulo; Taxas de serviços semestrais $primeiraPropinaMensal), através de um depósito Bancário no  Millenium BIM, na conta numero: 475827778 - NIB 000100000047582777857 - Universidade Rovuma;</li><br>
                <li>Após o depósito, dirigir-se à Direcção do Registo Académico em Nampula ou aos Departamentos de Registo Académico dos Institutos(Lichinga e Montepuez) com o talão de depósito e a ficha impressa de pré-inscrição.</li>

            </ul>
          </div>
        ";
    }



        $str = <<<TEXT
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Comprovativo de Preinscição</title>
                    <style type="text/css">
                        *{
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                            font-weight: 400;
                            font-size: 12pt;
                        }
                        .recepient-header{
                            margin-top: 80px;
                            margin-bottom: 40px;
                            width: 100%;
                            text-align: center;
                        }

                        .recepient-header h1, h2{
                            font-size: 12pt;
                            font-weight: 600;
                        }

                        .recepient-header h1{
                            line-height: 35px;
                        }

                        .recepient-body{
                            width: 100%;
                            display: flex;
                            justify-content: space-between;
                            align-items: centers;
                            margin-bottom: 10px;
                            flex-wrap: wrap;
                        }

                        .recepient-body h4{
                            font-size: 10pt;
                            line-height: 23px;
                        }

                        /* Estilizando a tabela */
                        table, th, td{
                            border: 1px solid #000000;
                            text-align: center;
                            font-size: 8pt;
                            border-collapse: collapse;
                        }

                        th{
                            font-weight: 600;
                        }

                        img{
                            border-radius: 50%;
                        }

                        li{
                            font-size: 9pt;
                            text-align: justify;
                        }

                    </style>
                </head>
                <body style="padding: 0 100px; font-family: "Open-sans", sans-serif;">
                    <div class="recepient-header">
                        <img src="https://sigim.co.mz/img/logo.jpg" style="width: 70px;">
                        <h1>Universidade Rovuma</h1>
                        <h2>Direcção do Registo Académico</h2>
                        <h1 style="text-decoration:underline;text-transform:uppercase">Ficha de Pré-inscrição Semestral</h2>
                    </div>
                    <div class="recepient-body">
                        <div style="width: 100%; margin-top: 10px;">
                            <h4 style="font-weight: 700 !important; margin-bottom: 5px;">Informação Pessoal
                            <span style="margin-left:300px; font-size:12px ;font-weight: 700 !important"> Pré-inscrição para o <span style="font-size:12px;font-weight: 700 !important">$enrollment->semestre</span>º semestre</span>
                            </h4>
                            <table style="width: 100%;">
                                <tr>
                                    <th>Numero </th>
                                    <th>Código do estudante</th>
                                    <th>Nome do estudante</th>
                                    <th>Data</th>
                                    <th>Estado</th>
                                </tr>
                                <tr>
                                    <td>$student->id</td>
                                    <td>
                                        $student->code
                                    </td>
                                    <td>
                                        $student->first_name $student->last_name
                                    </td>
                                    <td>
                                        $enrollment->created_at
                                    </td>
                                    <td>
                                        $status
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 100%; margin-top: 15px;">
                            <h4 style="font-weight: 700 !important;">Detalhes da Pré-inscrição</h4>
                            $str_itemsPre
                        </div>
                    </div>
                    <footer style="position: fixed; width: 100%; bottom: 25; left: 0; padding: 0 25px;">
                        <span style="font-style: italic; font-size: 8pt; font-weight: 400;">Procesado por SIGIM<sub style="font-size: 8pt;">v1.2.0-beta</sub></span>
                    </footer>
                </body>
            </html>
        TEXT;

        return $str;
    }

    private function printerApproved($enrollment){

        if ($enrollment->enrollment_status == 1) {
            $status = "Pendente";
        }elseif ($enrollment->enrollment_status== 2) {
            $status = "Aprovada";
        }elseif($enrollment->enrollment_status== 0){
            $status = "Cancelada";
        }
        $taxaMatricula = "Taxa de matrícula;";
        $primeiraPropinaMensal = "e a primeira propina mensal";
        if($enrollment->semestre >1){
            $taxaMatricula = "";
            $primeiraPropinaMensal="";
        }

        $data = date('d-m-Y H:i:s');
        $manager = $enrollment->student->manager;
        $faculty = $enrollment->faculty->label;
        $course = $enrollment->course->label;
        $sewing = $enrollment->sewingLine->label;
        $student = $enrollment->student;
        $str_itemsPre='';
        $taxaPorDisciplinas = ($enrollment->taxa) * ($enrollment->numero_disciplinas);
        $taxaLabel = "Taxa de inscrição por disciplina ( $enrollment->numero_disciplinas x $enrollment->taxa,00)";
        $str_itemsPre = $str_itemsPre."
        <div style='margin-top: 5px;'>
                                <table style='width: 100%;'>
                                <tr>
                                    <th>Ordem</th>
                                    <th>Referente a:</th>
                                    <th>Montante (MT)</th>
                                </tr>
                                <tr>
                                <td>1</td>
                                <td>Taxas de serviços semestrais</td>
                                <td>1750,00</td>

                                </tr>
                                <tr>
                                <td>2</td>
                                <td>$taxaLabel</td>
                                <td>$taxaPorDisciplinas,00</td>

                                </tr>

                                </table>
                                 <div style='margin-left: 453px;border: 1px solid; border-top:none; align-items:center; text-align: center; margin-bottom:20px;'>

                                    <strong>Total</strong>
                                    <strong>$enrollment->valor,00</strong>
                                </div>

             </div>
        ";


        $str = <<<TEXT
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Comprovativo de Preinscicao</title>
                    <style type="text/css">
                        *{
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                            font-weight: 400;
                            font-size: 12pt;
                        }
                        .recepient-header{
                            margin-top: 80px;
                            margin-bottom: 40px;
                            width: 100%;
                            text-align: center;
                        }

                        .recepient-header h1, h2{
                            font-size: 12pt;
                            font-weight: 600;
                        }

                        .recepient-header h1{
                            line-height: 35px;
                        }

                        .recepient-body{
                            width: 100%;
                            display: flex;
                            justify-content: space-between;
                            align-items: centers;
                            margin-bottom: 10px;
                            flex-wrap: wrap;
                        }

                        .recepient-body h4{
                            font-size: 10pt;
                            line-height: 23px;
                        }

                        /* Estilizando a tabela */
                        table, th, td{
                            border: 1px solid #000000;
                            text-align: center;
                            font-size: 8pt;
                            border-collapse: collapse;
                        }

                        th{
                            font-weight: 600;
                        }

                        img{
                            border-radius: 50%;
                        }

                        li{
                            font-size: 9pt;
                            text-align: justify;
                        }

                    </style>
                </head>
                <body style="padding: 0 100px; font-family: "Open-sans", sans-serif;">
                    <div class="recepient-header">
                        <img src="https://sigim.co.mz/img/logo.jpg" style="width: 70px;">
                        <h1>Universidade Rovuma</h1>
                        <h2>Direcção do Registo Académico</h2>
                        <h1 style="text-decoration:underline;text-transform:uppercase">Ficha de Inscrição Semestral</h2>
                    </div>
                    <div class="recepient-body">
                        <div style="width: 100%; margin-top: 10px;">
                            <h4 style="font-weight: 700 !important; margin-bottom: 5px;">Informação Pessoal
                            <span style="margin-left:300px; font-size:12px ;font-weight: 700 !important"> Inscrição para o <span style="font-size:12px;font-weight: 700 !important">$enrollment->semestre</span>º semestre</span>
                            </h4>
                            <table style="width: 100%;">
                                <tr>
                                    <th>Numero de inscrição</th>
                                    <th>Código do estudante</th>
                                    <th>Nome do estudante</th>
                                    <th>Data de inscrição</th>
                                    <th>Estado</th>
                                </tr>
                                <tr>
                                    <td>$student->id</td>
                                    <td>
                                        $student->code
                                    </td>
                                    <td>
                                        $student->first_name $student->last_name
                                    </td>
                                    <td>
                                        $enrollment->updated_at
                                    </td>
                                    <td>
                                        $status
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div style="width: 100%; margin-top: 15px;">
                            <h4 style="font-weight: 700 !important; margin-bottom: 5px;">Detalhes da Inscrição</h4>
                            $str_itemsPre
                            <div style="margin-top: 15px;">
                                <h4 style="font-size: 7pt;">Inscrição aprovada por: $manager->first_name $manager->last_name</h4>
                            </div>
                        </div>
                    </div>
                    <footer style="position: fixed; width: 100%; bottom: 25; left: 0; padding: 0 25px;">
                        <span style="font-style: italic; font-size: 8pt; font-weight: 400;">Processado por SIGIM<sub style="font-size: 8pt;">v1.2.0-beta</sub></span>
                    </footer>
                </body>
            </html>
        TEXT;

        return $str;
    }
}
