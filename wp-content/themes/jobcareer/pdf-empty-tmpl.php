<?php /* Template Name: pdf-empty-tmpl */ ?>
<?php
$pdf = new FPDF();
        $pdf->AddPage();        
        $pdf->Image($_POST['com_img'], 10,10,30);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30);
        $pdf->Cell(40, 10, $_POST['nm_pdf_com_name']);
        $pdf->Ln(12);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30);
        $pdf->Cell(40, 10, "Post Date: " . $_POST['nm_pdf_post_date']);
        $pdf->Ln(12);
        $pdf->Cell(30);
        $pdf->Cell(10, 2, "Ad Expire Date: " . $_POST['nm_pdf_add_exp']);
        $pdf->Cell(60);
        $pdf->Cell(40, 2, "Apply Before: " . $_POST['nm_pdf_apply_befor']);
        $pdf->Ln(8);
        $pdf->Cell(30);
        $pdf->Cell(10, 2, "Applications : " . $_POST['nm_pdf_app']);
        $pdf->Cell(40);
        $pdf->Cell(10, 2, "Views : " . $_POST['nm_pdf_views']);
        $pdf->Line(10, 50, 200, 50);
        $pdf->Cell(10);
        $pdf->Ln(30);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 2, "JOB OVERVIEW - (Ref # ".  $_POST['nm_pdf_job_ref'] . ")");
        $pdf->Cell(100);
        $pdf->Cell(40, 2, "JOB DETAIL");
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(10);
        $pdf->Cell(10, 2, $_POST['nm_pdf_content']);

$pdf->Ln(1);
        $pdf->Cell(140);
        /*$pdf->Cell(40, 2, "Offerd Salary");
        $pdf->Ln(7);
        $pdf->Cell(140);
        $pdf->Cell(40, 2, "0- $2000");
        
        $pdf->Ln(10);
        $pdf->Cell(140);
        $pdf->Cell(40, 2, "Experience");
        $pdf->Ln(7);
        $pdf->Cell(140);
        $pdf->Cell(40, 2, "2 Years");
        
        /*$pdf->Ln(10);
        $pdf->Cell(140);
        $pdf->Cell(40, 2, "Gender");
        $pdf->Ln(10);
        $pdf->Cell(140);
        $pdf->Cell(40, 2, "Male"); */
        
        $pdf->Ln(10);
        $pdf->Cell(140);
        $pdf->Cell(40, 2, "Qualification");
        $pdf->Ln(7);
        $pdf->Cell(140);
        $pdf->Cell(40, 2, "Diploma");


        
        $pdf->Output();
?>