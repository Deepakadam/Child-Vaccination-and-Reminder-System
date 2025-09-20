<?php
ob_start(); // Start output buffering

require('../tcpdf/tcpdf.php');
include '../includes/db_connect.php';

if (isset($_GET['child'])) {
    $child_name = mysqli_real_escape_string($conn, $_GET['child']); // Prevent SQL injection

    // Create new PDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Vaccination System');
    $pdf->SetTitle('Vaccination Report');
    $pdf->SetHeaderData('', 0, 'Vaccination Report', "Child Name: $child_name");
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetMargins(10, 25, 10);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->AddPage();
    
    // Table header
    $html = '<h3>Vaccination Report</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="5">';
    $html .= '<tr>
                <th><b>Vaccine Name</b></th>
                <th><b>Scheduled Date</b></th>
                <th><b>Status</b></th>
             </tr>';
    
    // Fetch vaccination records
    $query = "SELECT v.vaccine_name, vs.scheduled_date, vs.status 
              FROM vaccinationschedules vs
              JOIN children c ON vs.child_id = c.id
              JOIN vaccines v ON vs.vaccine_id = v.id
              WHERE c.name = '$child_name' 
              ORDER BY vs.scheduled_date";
    
    $result = mysqli_query($conn, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>
                    <td>' . $row['vaccine_name'] . '</td>
                    <td>' . $row['scheduled_date'] . '</td>
                    <td>' . $row['status'] . '</td>
                 </tr>';
    }
    
    $html .= '</table>';
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // Clean output buffer before sending PDF
    ob_end_clean();
    
    // Output PDF
    $pdf->Output("Vaccination_Report_$child_name.pdf", 'D');
    exit;
}
?>
