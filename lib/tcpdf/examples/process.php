<?php 
/**
 * I decided to put all of the necessary classes in one file
 * to make it easy to follow for the code challenge.
 */
ini_set('display_errors', true);
error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');
?>
<?php //autoloader
$tcpdf_include_dirs = array(
		realpath('/var/www/ndev/master/public/lib/tcpdf/tcpdf.php'),
		'/usr/share/php/tcpdf/tcpdf.php',
		'/usr/share/tcpdf/tcpdf.php',
		'/usr/share/php-tcpdf/tcpdf.php',
		'/var/www/tcpdf/tcpdf.php',
		'/var/www/html/tcpdf/tcpdf.php',
		'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
	if (@file_exists($tcpdf_include_path)) {
		require_once($tcpdf_include_path);
		break;
	}
}
?>
<?php 
class RssReader{
	public $xml;
	
	public function __construct($rsspage){
		$this->rsspage = $rsspage;
	}
	
	public function getXml(){
		try{
			return new SimpleXMLElement($this->rsspage, null, true);
		}catch(Exception $e){
			var_dump($e); exit;
		}
	}
}
?>
<?php //formats the page for pdf display
class PageDecorator{
	public $page;
	
	public function __construct($page){
		$this->page = $page;
	}
	
	public function getPage() {
		$out = null;
		
		$out .= (string)$this->page->pubDate;
		$out .= '<div>';
		$out .= (string)$this->page->title;
		$out .= '</div>';
		$out .= '<div>';
		$out .= (string)$this->page->description;
		$out .= '</div>';
		
		return $out;
	}
}
?>
<?php 
class pdfWriter{
	public static $pdf;
	
	public function write($page){ 		
		self::$pdf->AddPage ();		
		self::$pdf->writeHTMLCell ( 400, 200, 0, 40, "$page", 0, 0, 0, true, 1, false );		
		return;
	}
	
	public function printit(){
		self::$pdf->Output ( 'challenge.pdf', 'I' );
	}
	
	public function setupPdf(){
		
		self::$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
		 
		self::$pdf->SetHeaderData ( null, PDF_HEADER_LOGO_WIDTH, 'Put some header here', null );
		
		self::$pdf->setHeaderFont ( Array (
				PDF_FONT_NAME_MAIN,
				'',
				PDF_FONT_SIZE_MAIN
		) );
		self::$pdf->setFooterFont ( Array (
				PDF_FONT_NAME_DATA,
				'',
				PDF_FONT_SIZE_DATA
		) );
		
		self::$pdf->SetDefaultMonospacedFont ( PDF_FONT_MONOSPACED );
		
		self::$pdf->SetMargins ( PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT );
		self::$pdf->SetHeaderMargin ( PDF_MARGIN_HEADER );
		self::$pdf->SetFooterMargin ( PDF_MARGIN_FOOTER );
		
		self::$pdf->SetAutoPageBreak ( FALSE, PDF_MARGIN_BOTTOM );
		
		self::$pdf->setImageScale ( PDF_IMAGE_SCALE_RATIO );
		
		if (@file_exists ( dirname ( __FILE__ ) . '/lang/eng.php' )) {
			require_once (dirname ( __FILE__ ) . '/lang/eng.php');
			self::$pdf->setLanguageArray ( $l );
		}
		
		self::$pdf->setFontSubsetting ( true );
		
		self::$pdf->SetFont ( 'helvetica', '', 14, '', true );
	}
}
?>
<?php // controller
if(!empty($_POST['rsspage'])){
	$rsspage = htmlentities($_POST['rsspage'], ENT_QUOTES); // probably not necessary
	
	// gets xml rss
	$reader = new RssReader($rsspage);
    $xml = $reader->getXml();
    
    // writes to pdf
	$writer = new PdfWriter();
	$writer->setupPdf();
	
	$n = 0; // get rss feeds - limit 5
	foreach ($xml->channel->item as $page){	
		if($n <= 4){	
			$decorator = new PageDecorator($page); // format the page for html
			$writer->write($decorator->getPage()); // inject the formatted page into pdf writer
		}
		$n++;
	}
	$writer->printit(); // print all 5 pdf pages
}
?>