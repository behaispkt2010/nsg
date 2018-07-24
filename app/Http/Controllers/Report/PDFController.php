<?php
namespace App\Http\Controllers\Report;
/**
	*-------------------------------------------------------------------------*
	* 
	* PDF reporst
	*
	* 処理概要/process overview    	:
	* 作成日/create date            	:    
	* 作成者/creater                	:    
	*
	* @package                     	:    
	* @copyright                   	:    
	* @version                    	:    
	*-------------------------------------------------------------------------*
	* show + save + meger pdf
	*
	*
	*
	*
	*/
use App\Http\Controllers\Controller;
use Request,PDF,PdfMerger;
use DB,Response,App,Session,File,Input,Redirect;

class PDFController extends Controller {
	/*
    *
    *
    *   variable define for Controller
    *
    *
    */
	private $temp_folder ;
	private $form_folder ;
	private $fixed_folder ;
	/*
    * contrustor
    * -----------------------------------------------
    * @author      :   
    * @param       :   null
    * @return      :   null
    * @access      :   public
    * @see         :   remark
    */
	public function __construct(){
		
		$this->temp_folder 	= \Config::get('app.pdf_folder_temp');
		$this->form_folder 	= \Config::get('app.pdf_folder_form');
		$this->fixed_folder = \Config::get('app.pdf_folder_fixed');	
	}
	/*
    * show pdf 
    * -----------------------------------------------
    * @author      :   
    * @param       :   null
    * @return      :   null
    * @access      :   public
    * @see         :   remark
    */
	public function getShowPdfTemp($file_name){
		try{
			
			$file_to_view = '/reports/pdf/temp/'.$file_name;
			return view('layouts.pdf.show',compact('file_to_view','file_name'));
		}catch(Exception $e){
			
            return response()->json(array('response'=>false));
        }
	}

	/*
    * Merger pdf 
    * -----------------------------------------------
    * @author      :   
    * @param       :   null
    * @return      :   null
    * @access      :   public
    * @see         :   remark
    */
	public function getMergerPdfTemp($array,$file_fixed_array){
		try{
			//pdf file merge
			foreach ($array as $key => $value) {
				$file_name 		= $this->temp_folder.$value;
				$file_name   	= $this->getUTF8($file_name);
				PdfMerger::addPDF($file_name,'all');
			}
			//with pdf file fixed
			foreach ($file_fixed_array as $key => $value) {
				$file_name_fixed 	= $this->fixed_folder.$value;
				$file_name_fixed   	= $this->getUTF8($file_name_fixed);
				PdfMerger::addPDF($file_name_fixed,'all');
			}

			//file name path
			$file_name_end 		= $this->temp_folder.$array[0];
			$file_name_end   	= $this->getUTF8($file_name_end);
			//merger
			PdfMerger::merge('file', $file_name_end, 'P');
			//config to view
			$file_to_view = $array[0];

			return $file_to_view;

		}catch(Exception $e){
            return response()->json(array('response'=>false));
        }
	}



	/*
    * count line of pdf file 
    * -----------------------------------------------
    * @author      :   
    * @param       :   null
    * @return      :   null
    * @access      :   public
    * @see         :   remark
    */
	function getNumPagesInPDF($file){
	    if(!file_exists($file))return null;
	    if (!$fp = @fopen($file,"r"))return null;
	    $max=0;
	    while(!feof($fp)) {
	            $line = fgets($fp,255);
	            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
	                    preg_match('/[0-9]+/',$matches[0], $matches2);
	                    if ($max<$matches2[0]) $max=$matches2[0];
	            }
	    }
	    fclose($fp);

	    return (int)$max;
	}


	/*
    * count line of pdf file 
    * -----------------------------------------------
    * @author      :   
    * @param       :   null
    * @return      :   null
    * @access      :   public
    * @see         :   remark
    */
	public function getUTF8($file){
	   	if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
			return mb_convert_encoding($file, 'CP932', 'UTF-8');
		}else{
			return $file;
		}
	}
	/*
    * add images to pdf
    * -----------------------------------------------
    * @author      :   
    * @param       :   null
    * @return      :   null
    * @access      :   public
    * @see         :   remark
    */
	public function addImagesPdf($file){
	   	if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
			return mb_convert_encoding($file, 'CP932', 'UTF-8');
		}else{
			return $file;
		}
	}
}