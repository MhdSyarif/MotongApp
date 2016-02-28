<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Model{

	function get_uraian($conn2="",$query, $select){
		if($conn2){
			$conndb = $this->load->database($conn2, TRUE);
			$data = $conndb->query($query);
		}else{
			$data = $this->db->query($query);
		}
		if($data->num_rows() > 0){
			$row = $data->row();
			return $row->$select;
		}else{
			return "";
		}
		return 1;
	}
	
	function get_result($conn2="",&$query){
		if($conn2){
			$conndb = $this->load->database($conn2, TRUE);
			$data = $conndb->query($query);
		}else{
			$data = $this->db->query($query);
		}
		if($data->num_rows() > 0){
			$query = $data;
		}else{
			return false;
		}
		return true;
	}
	
	function get_combobox($conn2= FALSE,$query, $key, $value, $empty = FALSE, &$disable = ""){
		$combobox = array();
		if($conn2){
			$conndb = $this->load->database($conn2, TRUE);
			$data = $conndb->query($query);
		}else{
			$data = $this->db->query($query);
		}
		if($empty) $combobox[""] = "&nbsp;";
		if($data->num_rows() > 0){
			$kodedis = "";
			$arrdis = array();
			foreach($data->result_array() as $row){
				if(is_array($disable)){
					if($kodedis==$row[$disable[0]]){
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}else{
						if(!array_key_exists($row[$disable[0]], $combobox)) $combobox[$row[$disable[0]]] = $row[$disable[1]];
						if(!array_key_exists($row[$key], $combobox)) $combobox[$row[$key]] = str_replace("'", "\'", "&nbsp; &nbsp;&nbsp;".$row[$value]);
					}
					$kodedis = $row[$disable[0]];
					if(!in_array($kodedis, $arrdis)) $arrdis[] = $kodedis;
				}else{
					$combobox[$row[$key]] = str_replace("'", "\'", $row[$value]);
				}
			}
			$disable = $arrdis;
		}
		return $combobox;
	}
	
	function post_to_query($array, $except=""){
		$data = array();
		foreach($array as $a => $b){
			if(is_array($except)){
				if(!in_array($a, $except)) $data[$a] = $b;
			}else{
				$data[$a] = $b;
			}
		}
		return $data;
	}

	function get_menu(){
		#$db = $this->load->database("iutm_db", TRUE);	
		$um_role = $this->newsession->userdata('id_role');
		$SQL = "SELECT A.ID, A.PARENT_ID, A.TITLE, A.URL, A.URL_TYPE, A.MENU_ORDER, A.MENU_TYPE, A.MENU_ICON, A.TARGET
				FROM tbldmmenu A 
				INNER JOIN tbldmmenurole B ON A.ID = B.ID_MENU
				WHERE A.ID NOT IN (8) AND B.ID_GROUP = ".$um_role."
				ORDER BY A.MENU_ORDER ASC";	
		$query = $db->query($SQL);
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$id         = $row["ID"];
				$parent_id  = $row["PARENT_ID"];
				$title      = $row["TITLE"];
				$url        = $row["URL"];
				$url_type   = $row["URL_TYPE"];
				$menu_order = $row["MENU_ORDER"];
				$menu_type  = $row["MENU_TYPE"];
				$menu_icon  = $row["MENU_ICON"];				
				$target     = $row["TARGET"];
				
				$data[$parent_id][] = array("id"			=> $id,
											  "title"		=> $title,
											  "url"			=> $url,
											  "url_type"	=> $url_type,
											  "target"		=> $target,
											  "menu_order"	=> $menu_order,	
											  "menu_type"	=> $menu_type,	
											  "menu_icon"	=> $menu_icon								  
											  );
			}
			return $data;
		}
		else{
			return 0;
		}
	}
	
	function draw_menu(){
		
		$data   = $this->get_menu();
		$menu   =  $this->draw_menu_content($data);
		$data   = array('menu' => $menu);
		$result = $this->load->view("menu", $data, true);
		return $result;
	}
	
	function draw_menu_content($data,$parent=0) {
		static $i = 1;
		$tab = str_repeat("\t\t", $i);
		if(array_key_exists($parent,$data)){
			if ($data[$parent]) {
				if($parent == 0){
					$html = "\n$tab<ul class=\"nav nav-pills\">";
				}else{
					$html = "\n$tab<ul class=\"dropdown-menu\">";
				}
				$i++;
				for($c=0;$c<count($data[$parent]);$c++){
					#start get menu active
					$active = $this->get_uraian('iutm_db','SELECT MENU_ACTIVE FROM tbldmmenu WHERE id='.$data[$parent][$c]["id"], 'MENU_ACTIVE');
					if($active==1) $classactive = "active";
					else $classactive="";
					#ecd get menu active
					$arrdropdown = array(4,9);
					$child = $this->draw_menu_content($data, $data[$parent][$c]["id"]);
					if ($data[$parent][$c]["url_type"]=='base') $url_type = base_url();
					elseif ($data[$parent][$c]["url_type"]=='site') $url_type = site_url();
					if(in_array($data[$parent][$c]["id"],$arrdropdown)){#kondisi dropdown menu
						$html .= "\n\t$tab<li class=\"dropdown menu ".$classactive."\" id=\"menu_".$data[$parent][$c]["id"]."\">";
						$html .='<a class="dropdown-toggle" data-toggle="dropdown" href="'.$data[$parent][$c]["url"].'" target="'.$data[$parent][$c]["target"].'"><i style="margin-top:7px;" class="icon-'.$data[$parent][$c]["menu_icon"].' icon-large"></i>'.$data[$parent][$c]["title"].'<b class="caret"></b></a>';
					}
					else{
						$html .= "\n\t$tab<li id=\"menu_".$data[$parent][$c]["id"]."\" class=\"menu ".$classactive."\" onclick=\"menu_active(this.id)\">";
						$html .= '<a href="'.$url_type.$data[$parent][$c]["url"].'" target="'.$data[$parent][$c]["target"].'"><i style="margin-top:7px;" class="icon-'.$data[$parent][$c]["menu_icon"].' icon-large"></i> '.$data[$parent][$c]["title"].'</a>';
					}
					
					if ($child){
						$i--;
						$html .= $child;
						$html .= "\n\t$tab";
					}
					$html .= '</li>';
				}
				$html .= "\n$tab</ul>";
				return $html;
			} 
			else{
				$html="";
				return false;
			}
		}
		else{
			return false;	
		}
		
	}
	
	function in_menu($menu_id){
		$group_id = $this->newsession->userdata('user_group')?$this->newsession->userdata('user_group'):'O';
		$type_id = $this->newsession->userdata('org_type')?$this->newsession->userdata('org_type'):'G';
		$query = "SELECT count(*) as ada FROM m_group_menu WHERE group_id = '$group_id' AND type_id = '$type_id' AND menu_id = '$menu_id'";
		$hasil = (int)$this->get_uraian($query, "ada");
		if($hasil>0)
			return TRUE;
		else
			return FALSE;
	}

	function get_content($content, $message="", $menu="", $addHeader=""){
		$this->lang->load('setting'); 
		$appname = $this->lang->line('tittle');
		$lang_menu = $this->lang->line('menu');
		if($lang_menu=='menu_en') $footer  = $this->load->view('footer_en', '', true);
		else $footer  = $this->load->view('footer', '', true);
		$header  = $this->load->view('header', $addHeader, true);
		$menu    = $this->load->view('menu', $addHeader, true);
		$top     = $this->load->view('top', '', true);
		$data    = array('_appname_' => $appname,
					  	 '_html_' => $content,
					  	 '_header_' => $header,
						  '_top_' => $top,
						 '_footer_' => $footer,
					  	 '_menu_' => $menu,
					  	 '_message_' => $message);
		return $data;
	}
	
	function set_body_email($html,$header,$title,$type=""){
		if($type=="cmos"){
			$headertitle = "E-CMOS";
		}else{
			$headertitle = "CMOS-API INTEGRATION";	
		}
		$body = '<html><body style="background: #ffffff; color: #222; font-family: Arial; margin: 20px; color: #363636; font-size:11px;"><table style="font-family: Arial; border-collapse:collapse;"><tr><td style="width:100px;color: #5598ca;font-size: 20px;" valign="middle">'.$headertitle.'</td><td style="color: #222; padding-left:15px; font-size: 20px; border-left:1px solid;"><b>'.$title.'</b><div style="color: #888; font-size: 10px;">CONFIDENTIAL</div></td></tr><tr><td colspan="2" height="5"></td></tr></table><div style="height:15px;"></div><table style="background: #efefef; font-size:11px; color: #444; font-family: Arial;"  cellpadding=3 cellspacing=2><tr><td></td></tr></table>'.$html.'<div style="font-size: 10px; color: #888;"><br><b style="color:#222;">Electronic Data Interchange Indonesia, PT</b><br>Wisma SMR 1st, 3rd &amp; 10th Floor<br>Yos Sudarso Kav. 89 Sunter<br>Jakarta - 14350</div></body></html>';
		return $body;
	}
	
	function send_mail($to, $subject, $body, $bcc="",$type=""){
		$body   = $this->set_body_email($body,$to,$subject,$type);
		$config = array(
			'protocol' => 'smtp',
			//'smtp_host' => 'mail2.edi-indonesia.co.id',
			'smtp_host' => '10.1.12.1',
			'smtp_port' => 25,
			//'smtp_user' => 'butir_v@edi-indonesia.co.id',
			//'smtp_pass' => 'M4cB00kAir',
			//'smtp_user' => 'smartpay@edi-indonesia.co.id',
			//'smtp_pass' => 'P@ssw0rd',
			'smtp_user' => '',
			'smtp_pass' => '',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1',
			'crlf' => "\r\n",
			'start_tls' => true
		);
		/*$config = array(
					  'protocol' => 'smtp',
					  'smtp_crypto' => 'ssl',
					  'smtp_host' => 'smtp.googlemail.com',
					  'smtp_port' => 465,
					  'smtp_user' => 'imrk.noreply@gmail.com',
					  'smtp_pass' => 'sdn18pagi',
					  'mailtype' => 'html',
					  'charset' => 'iso-8859-1',
					  'crlf' => "\r\n",
					  'start_tls' => true
         		 ); */
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('noreply.services.api@cmos.com', 'Administrator E-CMOS');
		$email = str_replace(';', ',', $to);
		$this->email->to($email);
		if($bcc){$bcc = str_replace(';', ',', $bcc);$this->email->bcc($bcc);}
		$this->email->subject($subject);
		$this->email->message($body);
		if($this->email->send()){
			return true;
		}else{
			print_r($this->email->print_debugger());die('xxxx');
		}
		
	}
		
	function generate_kode($inisial="",$digit=""){
		$random = date('s');
		$char   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ9876543210abcdefghijklmnopqrstuvwxyz1234567890';
		$rchar  = substr(str_shuffle($char), 7, ($digit)?$digit:6);
		return $inisial.$random.$rchar;
	}
	
	function auto_id($tabel,$field,$where,$length,$inisial){
		if(is_array($where)){
			$strwhere = "";
			foreach ($where as $key => $val){
				$strwhere .= $key."=".$this->db->escape($val).' AND ';					
			}
			if(strlen($strwhere)>0){
				$where = "WHERE ".substr($strwhere,0,-5);	
			}
		}else{
			$where = "";	
		}
		
		$struktur = $this->db->query("select * from $tabel") or die("query tidak dapat dijalankan!");
		$fields = $this->db->field_data($tabel);
		
		foreach ($fields as $column)
		{
		   if(strtolower($column->name) == strtolower($field)){
			   $field   = $column->name;
			   if($length)
			   		$panjang = $length;
			   else
			   		$panjang = $column->max_length;
		   }
		}
		/*echo $field->name;
	    echo $field->type;
	    echo $field->max_length;
	    echo $field->primary_key.'<hr>';*/
		
		$row = $struktur->num_rows();
		
		$panjanginisial = strlen($inisial);
		$awal = $panjanginisial + 1;
		$bnyk = $panjang-$panjanginisial;
		
		if ($row >= 1){
		  $query = $this->db->query("select max(substring($field,$awal,$bnyk)) as max from $tabel $where") or die("query tidak dapat dijalankan!");
		  $hasil = $query->row_array();
		  $angka = intval($hasil['max']);
		}
		else{
		  $angka = 0;
		}
		
		$angka++;
		$tmp= "";
		for ($i=0; $i < ($panjang-$panjanginisial-strlen($angka)) ; $i++){
		  $tmp = $tmp."0";
		}
		
		return strval($inisial.$tmp.$angka);
	}
	
	function cek_empty_array($arr){
		$empty=1;
		foreach($arr as $key => $val){
			if($val!="") $empty = 0;
		}
		return $empty;
	}
	
	function get_exist($conn2="",$tabel,$where,$key){
		$query = "SELECT * from ".$tabel." WHERE ".$where." = '".$key."'";
		if($conn2){
			$conndb = $this->load->database($conn2, TRUE);
			$data   = $conndb->query($query);
		}else{
			$data = $this->db->query($query);
		}

		if($data->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function get_insert_select($tabel_name,$array_field,$array_key, $array_field_bypass=array())
	{
		if((is_array($array_field)) && (is_array($array_key)) && (is_array($array_key)))
		{
			#get field
			$banyak_field = count($array_field);
			$str_field="";
			for($a=0;$a<$banyak_field;$a++)
			{
				$str_field .= $array_field[$a].',';
			}
			if(strlen($str_field)>0) $str_field = substr($str_field,0,-1);
			
			#get field by pass
			$banyak_field_bypass = count($array_field_bypass);
			$str_field_bypass="";
			$str_value_bypass="";
			foreach($array_field_bypass as $keypass => $valuepass)
			{
				$str_field_bypass .= ",".$keypass.",";
				if(is_numeric($valuepass)) $str_value_bypass .= ",".$valuepass.",";
				else $str_value_bypass .= ",'".$valuepass."',";
			}
			if((strlen($str_field_bypass)>0) && (strlen($str_value_bypass)>0)) 
			{
				if($banyak_field_bypass>0){
					$str_field_bypass = substr($str_field_bypass,0,-1);
					$str_value_bypass = substr($str_value_bypass,0,-1);
					
					#replace
					$str_field_bypass = str_replace(array(",,"),array(","),$str_field_bypass);
					$str_value_bypass = str_replace(array(",,"),array(","),$str_value_bypass);
				}
			}
			#get where
			$str_where="";
			foreach($array_key as $key => $value)
			{
				if(is_numeric($value)) $str_where .= $key."=".$value." and ";
				else $str_where .= $key."='".$value."' and ";
			}
			if(strlen($str_where)>0) $str_where = substr($str_where,0,-5);
			$sql = "INSERT INTO ".$tabel_name." (".$str_field.$str_field_bypass.")
					SELECT ".$str_field.$str_value_bypass."
					FROM ".$tabel_name."
					WHERE ".$str_where;
			
			return $sql;
		}
		else
		{
			return false;
		}
		
	}
	
	function set_number($number)
	{
		$returnNumber = number_format($number,0,".",",");
		if (strpos($number,".") !== false)
		{
			$pecah = explode(".",$number);
			$desimal = $pecah[1];
			if (strlen($desimal) > 2)
				$desimal = substr($desimal,0,2);
			$returnNumber = number_format($pecah[0],0,".",",").".".$desimal;
		}
		return $returnNumber;
	}
	
	function call_api($method, $url, $data = false)
	{
		$curl = curl_init();
	
		switch ($method)
		{
			case "POST":
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
				curl_setopt($curl, CURLOPT_PUT, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				if ($data)
					$url = $url.'/'.$data;
				#curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"OAuth-Token: $token"));
		}
	
		// Optional Authentication
		//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		//curl_setopt($curl, CURLOPT_USERPWD, "winzaldi:Bismillah01");
	
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
		$result = curl_exec($curl);
	
		curl_close($curl);
	
		return $result;
	}
	
	function get_uploader($filename, $image) {
		$dir = '../uploads/android-uploader';
		if (file_exists($dir) && is_dir($dir)) {
			$path = $dir . "/" . $filename . '_' . md5($filename.date('YmdHis')) . '.jpg';
		} else {
			if (mkdir($dir, 0777, true)) {
				$path = $dir . "/" . $filename . '_' . md5($filename.date('YmdHis')) . '.jpg';
			} else {
				return FALSE;
			}
		}
		$dir = $this->base_64_to_jpeg($image, $path);
		if ($dir)
			return $dir;
		else
			return "FALSE";
	}
	
	function base_64_to_jpeg($image, $dir) {
		$ifp = fopen($dir, "wb");
		fwrite($ifp, base64_decode($image));
		fclose($ifp);
		return $dir;
	}
	
	function logProcess($id_entry,$status,$tipe,$user,$idstatus){
		date_default_timezone_set('Asia/Jakarta');
		$arrayLog = array('seqklaim'=>$id_entry,
						  'status'=>$status,
						  'tgl_log'=>date('Y-m-d H:i:s'),
						  'tipe_proses'=>$tipe,
						  'user_entry'=>$user,
						  'id_status'=>$idstatus);
		$this->db->insert('tbl_log', $arrayLog); 
	}
	
	function setAudit($seqklaim,$status,$keterangan="",$user,$idstatus){
		date_default_timezone_set('Asia/Jakarta');
		$arrayLog = array('seqklaim'=>$seqklaim,
						  'status'=>$status,
						  'tgl_aksi'=>date('Y-m-d H:i:s'),
						  'keterangan'=>$keterangan,
						  'user_aksi'=>$user,
						  'id_status'=>$idstatus);
		$this->db->insert('tbl_audit', $arrayLog); 
	}
	
	function create_file($namafile, $content, $dir) {
        if (!is_dir($dir))
            mkdir(str_replace('//', '/', $dir), DIR_WRITE_MODE, true);

        $pathfile = str_replace(array('//'), array('/'), $dir) . $namafile;
		
        if (file_exists($pathfile)) {
            $file = fopen($pathfile, "a");
            fwrite($file, $content . "\r\n");
            fclose($file);
            return true;
        } else {
            $file = fopen($pathfile, FOPEN_WRITE_CREATE_DESTRUCTIVE);
            if (!$file) {
                fclose($file);
                return false;
            } else {
                if (chmod($pathfile, 0777)) {
                    fwrite($file, $content . "\r\n");
                    fclose($file);
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
		
}