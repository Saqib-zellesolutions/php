<?php
require("fpdf/fpdf.php");
require("word.php");
require "config.php";

//customer and invoice details
$info = [
  "customer" => "",
  "address" => ",",
  "city" => "",
  "invoice_no" => "",
  "invoice_date" => "",
  "total_amt" => "",
  "words" => "",
];

//Select Invoice Details From Database
$sql = "select * from invoice where SID='{$_GET["id"]}'";
$res = $con->query($sql);
if ($res->num_rows > 0) {
  $row = $res->fetch_assoc();

  $obj = new IndianCurrency($row["GRAND_TOTAL"]);


  $info = [
    "customer" => $row["CNAME"],
    "address" => $row["CADDRESS"],
    "city" => $row["CCITY"],
    "invoice_no" => $row["INVOICE_NO"],
    "invoice_date" => date("d-m-Y", strtotime($row["INVOICE_DATE"])),
    "total_amt" => $row["GRAND_TOTAL"],
    "words" => $obj->get_words(),
  ];
}

//invoice Products
$products_info = [];

//Select Invoice Product Details From Database
$sql = "select * from invoice_products where SID='{$_GET["id"]}'";
$res = $con->query($sql);
if ($res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    $products_info[] = [
      "name" => $row["PNAME"],
      "price" => $row["PRICE"],
      "qty" => $row["QTY"],
      "total" => $row["TOTAL"],
    ];
  }
}

class PDF extends FPDF
{
  function Header()
  {

    //Display Company Info

    $this->Image('header.jpeg', 8, 04, 195);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(50, 10, "", 0, 1);
    $this->SetFont('Arial', '', 14);
    $this->Cell(50, 7, "", 0, 1);
    $this->Cell(50, 7, "", 0, 1);
    $this->Cell(50, 7, "", 0, 1);

    //Display INVOICE text
    $this->SetY(15);
    $this->SetX(-40);
    $this->SetFont('Arial', 'B', 18);
    $this->Cell(50, 10, "", 0, 1);

    //Display Horizontal line
    // $this->Line(0,48,210,48);
  }

  function body($info, $products_info)
  {

    //Billing Details
    $this->SetY(55);
    $this->SetX(10);
    $this->SetFont('Arial', 'B', 12);
    $this->Cell(50, 10, "Bill To: ", 0, 1);
    //Display Horizontal line
    $this->Line(10, 65, 50, 65);
    $this->SetFont('Arial', '', 10);
    $this->Cell(50, 8, "Name of Client: " . $info["customer"], 0, 1);
    $this->Cell(50, 7, "Company Name: " . $info["customer"], 0, 1);
    $this->Cell(50, 7, "Address: " . $info["address"], 0, 1);
    $this->Cell(50, 7, "City: " . $info["city"], 0, 1);
    $this->Cell(50, 7, "Contact #: " . $info["city"], 0, 1);

    //Display Invoice Heading
    $this->SetY(45);
    $this->SetX(-60);
    $this->SetFont('Arial', 'B', 16);
    $this->Cell(50, 10, 'INVOICE', 0, 1, 'R');

    //Display Invoice Description
    $this->SetY(55);
    $this->SetX(-55);
    $this->SetFont('Arial', '', 10);
    $this->Cell(50, 7, "Invoice No :      " . $info["invoice_no"]);

    //Display Invoice date
    $this->SetY(63);
    $this->SetX(-55);
    $this->Cell(50, 7, "Invoice Date :  " . $info["invoice_date"]);

    //Display Invoice due date
    $this->SetY(70);
    $this->SetX(-55);
    $this->Cell(50, 7, "Due Date :       " . $info["invoice_date"]);

    //Display Invoice Mode
    $this->SetY(78);
    $this->SetX(-55);
    $this->Cell(50, 7, "Invoice Mode : " . $info["invoice_date"]);

    //Display Table headings
    $this->SetY(105);
    $this->SetX(10);
    $this->SetFont('Arial', 'B', 12);
    $this->SetDrawColor(255,255,255);
    $this->SetLineWidth(0.7);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(229, 31, 204);
    $this->Rect(10, $this->GetY(), 190, 9, 'F');
    $this->Cell(90, 9, "DESCRIPTION", 1, 0, 'C');
    $this->Cell(50, 9, "Amount in USD '$'", 1, 0, "C");
    $this->Cell(50, 9, "Amount in Pkr 'Rs'", 1, 1, "C");
    $this->SetFont('Arial', '', 12);

    //Display table product rows
    foreach ($products_info as $row) {
      $this->SetFillColor(0, 157, 199); 
      $this->Rect(10, $this->GetY(), 190, 9, 'F');
      $this->Cell(90, 9, $row["name"], 1, 0, 'L');
      $this->Cell(50, 9, "", 1, 0, 'C');
      $this->Cell(50, 9, $row["total"], 1, 1, 'C');
    }
    //Display table empty rows
    for ($i = 0; $i < 7 - count($products_info); $i++) {
      $this->SetFillColor(0, 157, 199); 
      $this->Rect(10, $this->GetY(), 190, 9, 'F');
      $this->Cell(90, 9, "", 1, 0, 'L');
      $this->Cell(50, 9, "", 1, 0, 'C');
      $this->Cell(50, 9, "", 1, 1, 'C');
    }
    //Display table total row
    $this->SetY(180);
    $this->SetX(60);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(0.7);
    $this->SetTextColor(75,75,75);
    $this->SetFillColor(255, 255, 255);
    $this->Rect(10, $this->GetY(), 190, 9, 'F');
    $this->SetFont('Arial', 'B', 12);
    $this->Cell(40, 9, "TOTAL AMOUNT", 1, 0, "C");
    $this->Cell(100, 9, $info["total_amt"]."/=", 1, 1, "R");

    //Display amount in words
    $this->SetY(192);
    $this->SetX(10);
    $this->SetFont('Arial', 'B', 11);
    $this->Cell(0, 9, "Amount in Words: " . $info["words"], 1, 0, 1);
    // $this->SetFont('Arial','',12);
    // $this->Cell(0,9,$info["words"],0,1);

  }
  function Footer()
  {



    //set footer position
    $this->SetY(-50);
    $this->SetTextColor(0,0,0);
    $this->Image('footer.jpeg', 8, 255, 195);
    $this->SetFont('Arial', '', 12);
    $this->SetY(202);
    $this->Cell(205, 10, "Thank you for your Business!", 0, 1, "C");
    $this->Ln(3);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(0, 10, "Terms & Instructions", 0, 1, "L");
    $this->Line(10, 223, 50, 223);
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, "Make all Cheques Payable to", 0, 1, "L");
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(0, 5, "M/s Zelle Solutions", 0, 1, "L");
    $this->Cell(0, 5, "A/c # 1240 0981-065396-01-9", 0, 1, "L");
    $this->Cell(0, 5, "Bank Al-Habib Ltd.", 0, 1, "L");
    $this->Cell(0, 5, "NTN # 3888583-2", 0, 1, "L");
    //Display Footer Text
    $this->Cell(0, 10, "", 0, 1, "C");

  }

}
//Create A4 Page with Portrait 
$pdf = new PDF("P", "mm", "A4");
$pdf->AddPage();
$pdf->body($info, $products_info);
$pdf->Output();
?>