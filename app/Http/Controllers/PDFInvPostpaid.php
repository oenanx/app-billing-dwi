<?php
namespace App\Http\Controllers;
 
use App\Models\M_BSPostpaid;
use App\Models\M_BS_Detail_Postpaid;
use App\Models\Mod_Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Http\Controllers\Controller;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;
 
class PDFInvPostpaid extends Controller
{
    private $fpdf;
 
    public function __construct()
    {
         
    }
 
    public function index(Request $request)
    {
        if(Session::get('userid'))
        {
	        $custno     = $request->custno;
			//dd($custno);
            $month      = $request->month;
            $thn        = $request->thn;

            $bs_period  = $request->thn.$request->month;
            //dd($custno);

            if ($custno != "" || $custno != null)
            {
				//Jika customerno tidak kosong.
				$this->fpdf = new Fpdf;

                $customer = Mod_Company::query()
							->where('fapi', 1)
							->where('master_company.billingtype', 2)
                            ->where('customerno', $custno)
                            ->select('customerno', 'company_name','address','address2','address3','address4','address5','zipcode','phone_fax','npwpno')
                            ->first();
				//dd($customer);
				$customerno         = $customer->customerno;
				$customername       = $customer->company_name;
				$vatno              = $customer->npwpno;
				$billingaddress1    = $customer->address;
				$billingaddress2    = $customer->address2;
				$billingaddress3    = $customer->address3;
				$billingaddress4    = $customer->address4;
				$billingaddress5    = $customer->address5;
				$zipcode            = $customer->zipcode;
				$phone1             = $customer->phone_fax;
				//dd($phone1);
                $period = $bs_period;
                $report_date = "25/12/2021";
                
                $bs = M_BSPostpaid::query()
                        ->select('*', DB::raw('(PREVIOUSBALANCE-PREVIOUSPAYMENT-BALANCEADJUSTMENT+TOTALAMOUNT-TOTALDISCOUNT+TOTALVAT-USAGEADJUSTMENT-PENALTY) as AMOUNTDUE'), DB::raw('(TOTALAMOUNT-TOTALDISCOUNT+TOTALVAT-USAGEADJUSTMENT-PENALTY) as CHARGE'), DB::raw('(TOTALAMOUNT+USAGEADJUSTMENT+TOTALDISCOUNT) as BEFOREVAT'))
                        ->where('bs_postpaid.PERIOD', $bs_period)
                        ->where('bs_postpaid.TOTALUSAGE', '>', 0)
                        ->where('bs_postpaid.CUSTOMERNO', $customerno)
                        ->first();
				//dd($bs);
				
				if (is_null($bs) || $bs == "")
				{
					return response()->json(['error' => 'Error data usage not found !!!']);
				}
				else
				{
					$amountdue			= $bs->AMOUNTDUE;
					$duedate			= $bs->DUEDATE;
					$bsno				= $bs->BSNO;
					$laststatementdate	= $bs->LASTSTATEMENTDATE;
					$previousbalance	= $bs->PREVIOUSBALANCE;
					$balanceadj			= $bs->BALANCEADJUSTMENT * -1;
					$previouspay		= $bs->PREVIOUSPAYMENT * -1;
					$totrefund			= $bs->TOTALREFUND * -1;
					$prevbalance		= $previousbalance+$balanceadj+$previouspay+$totrefund;
					$totalamount		= $bs->TOTALAMOUNT;
					$charge				= $bs->CHARGE;
					$monthly			= $bs->MONTHLY;
					$totalusage			= 0;
					$usageadj			= $bs->USAGEADJUSTMENT * -1;
					$totdiscount		= $bs->TOTALDISCOUNT * -1;
					$beforevat			= $bs->BEFOREVAT;
					$totalvat			= $bs->TOTALVAT;
				}
				
				$create_by 			= Session::get('userid');
				$create_at 			= date('Y-m-d H:i:s');
				
				//Cek dahulu di table trans_postpaid apakah ada no invoicenya apa belum?
				$cek = DB::table('trans_postpaid')->where('CUSTOMERNO', $customerno)->where('BSNO', $bsno)->select(DB::raw('COUNT(BSNO) AS TOT_DATA'))->first();
				$cektotaldata	= $cek->TOT_DATA;
				
				if ($cektotaldata == 0 || $cektotaldata == "0")
				{
					//Insert ke table trans_postpaid
					DB::table('trans_postpaid')
					->insert(
								[
									'CUSTOMERNO'			=> $customerno,
									'BSNO'					=> $bsno,
									'DUEDATE'				=> $duedate,
									'NOMINAL_TAGIHAN'		=> $amountdue,
									'TRANSACTIONDATE'		=> date('Y-m-d H:i:s'),
									'PERIOD'				=> $bs_period,
									'CRT_USER'				=> $create_by,
									'CRT_DATE'				=> $create_at
								]
							);
				}

                $this->PrintChapter("$custno","$period","$report_date","$custno",$customername,$amountdue,"$duedate","$bsno","$laststatementdate","$vatno","$billingaddress1","$billingaddress2","$billingaddress3","$billingaddress4","$zipcode","$billingaddress5","$phone1",$previousbalance,$balanceadj,$previouspay,$totrefund,$prevbalance,$charge,$monthly,$totalusage,$usageadj,$totdiscount,$beforevat,$totalvat,$totalamount);
                $this->Footer();

                //$this->fpdf->AddPage('P');
                $this->fpdf->AliasNbPages();
                $this->fpdf->SetFont('times','',12);
                $this->fpdf->SetAuthor('o3n4nX');
                    
                $this->fpdf->Output('Invoice_'.$custno.'_'.$bs_period.'.pdf','D');

            }
            else
            {
                $bs = DB::table('bs_postpaid')
                        ->where('PERIOD', $bs_period)
                        ->where('TOTALUSAGE', '>', 0)
						->where('master_company.billingtype', 2)
						->where('fapi', 1)
                        ->join('master_company', 'master_company.customerno', '=', 'bs_postpaid.CUSTOMERNO')
                        ->select('bs_postpaid.CUSTOMERNO', 'DUEDATE', 'BSNO', 'LASTSTATEMENTDATE', 'PREVIOUSBALANCE', 'BALANCEADJUSTMENT', 'PREVIOUSPAYMENT', 'TOTALAMOUNT', 'USAGEADJUSTMENT','TOTALDISCOUNT','TOTALVAT','company_name','address','address2','address3','address4','address5','zipcode','phone_fax','npwpno', DB::raw('(PREVIOUSBALANCE-PREVIOUSPAYMENT-BALANCEADJUSTMENT+TOTALAMOUNT-TOTALDISCOUNT+TOTALVAT-USAGEADJUSTMENT-PENALTY) as AMOUNTDUE'), DB::raw('(TOTALAMOUNT-TOTALDISCOUNT+TOTALVAT-USAGEADJUSTMENT-PENALTY) as CHARGE'), DB::raw('(TOTALAMOUNT+USAGEADJUSTMENT+TOTALDISCOUNT) as BEFOREVAT'))
                        ->orderBy('bs_postpaid.CUSTOMERNO','desc')
                        ->get();

                $period = $bs_period;
                $report_date = "25/12/2021";
				
                for($i = 0; $i < count($bs); $i++) 
                {
					$this->fpdf = new Fpdf;

                    $customerno         = $bs[$i]->CUSTOMERNO;
                    $amountdue          = $bs[$i]->AMOUNTDUE;
                    $duedate            = $bs[$i]->DUEDATE;
                    $bsno               = $bs[$i]->BSNO;
                    $laststatementdate  = $bs[$i]->LASTSTATEMENTDATE;
                    $previousbalance    = $bs[$i]->PREVIOUSBALANCE;
                    $balanceadj         = $bs[$i]->BALANCEADJUSTMENT * -1;
                    $previouspay        = $bs[$i]->PREVIOUSPAYMENT * -1;
                    $totrefund          = 0;
                    $prevbalance        = ($bs[$i]->PREVIOUSBALANCE)+($bs[$i]->BALANCEADJUSTMENT * -1)+($bs[$i]->PREVIOUSPAYMENT * -1)+($totrefund);
                    $totalamount        = $bs[$i]->TOTALAMOUNT;

                    $charge             = $bs[$i]->CHARGE;
                    $monthly            = 0;
                    $totalusage         = 0;
                    $usageadj           = $bs[$i]->USAGEADJUSTMENT * -1;
                    $totdiscount        = $bs[$i]->TOTALDISCOUNT * -1;
                    $beforevat          = $bs[$i]->BEFOREVAT;
                    $totalvat           = $bs[$i]->TOTALVAT;

                    $customername       = $bs[$i]->company_name;
                    $vatno              = $bs[$i]->npwpno;
                    $billingaddress1    = $bs[$i]->address;
                    $billingaddress2    = $bs[$i]->address2;
                    $billingaddress3    = $bs[$i]->address3;
                    $billingaddress4    = $bs[$i]->address4;
                    $billingaddress5    = $bs[$i]->address5;
                    $zipcode            = $bs[$i]->zipcode;
                    $phone1             = $bs[$i]->phone_fax;
					$create_by 			= Session::get('userid');
					$create_at 			= date('Y-m-d H:i:s');
					
					//Cek dahulu di table trans_postpaid apakah ada no invoicenya apa belum?
					$cek = DB::table('trans_postpaid')->where('CUSTOMERNO', $customerno)->where('BSNO', $bsno)->select(DB::raw('COUNT(BSNO) AS TOT_DATA'))->first();
					$cektotaldata	= $cek->TOT_DATA;
					
					if ($cektotaldata == 0 || $cektotaldata == "0")
					{
						//Insert ke table trans_postpaid
						DB::table('trans_postpaid')
						->insert(
									[
										'CUSTOMERNO'			=> $customerno,
										'BSNO'					=> $bsno,
										'DUEDATE'				=> $duedate,
										'NOMINAL_TAGIHAN'		=> $amountdue,
										'TRANSACTIONDATE'		=> date('Y-m-d H:i:s'),
										'PERIOD'				=> $bs_period,
										'CRT_USER'				=> $create_by,
										'CRT_DATE'				=> $create_at
									]
								);
					}

                    $this->PrintChapter("$customerno","$period","$report_date","$customerno",$customername,$amountdue,"$duedate","$bsno","$laststatementdate","$vatno","$billingaddress1","$billingaddress2","$billingaddress3","$billingaddress4","$zipcode","$billingaddress5","$phone1",$previousbalance,$balanceadj,$previouspay,$totrefund,$prevbalance,$charge,$monthly,$totalusage,$usageadj,$totdiscount,$beforevat,$totalvat,$totalamount);		
                    $this->Footer();
					
                }

				$this->fpdf->AliasNbPages();
				$this->fpdf->SetFont('times','',12);
				$this->fpdf->SetAuthor('o3n4nX');
				
				$this->fpdf->Output('Invoice_'.$bs_period.'.pdf','D');
            }
        }
        else
        {
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

			Auth::logoutOtherDevices(Session::get('userid'));
			Auth::logoutOtherDevices(Session::get('realname'));
			Auth::logoutOtherDevices(Session::get('email'));
			Auth::logoutOtherDevices(Session::get('username'));
			Auth::logoutOtherDevices(Session::get('company_id'));
			Auth::logoutOtherDevices(Session::get('departemen_id'));
			Auth::logoutOtherDevices(Session::get('departemen'));
			Auth::logoutOtherDevices(Session::get('sex'));
			Auth::logoutOtherDevices(Session::get('login'));
			
			session()->forget('userid');
			session()->forget('realname');
			session()->forget('email');
			session()->forget('username');
			session()->forget('company_id');
			session()->forget('departemen_id');
			session()->forget('departemen');
			session()->forget('sex');
			session()->forget('login');
		
			session()->flush();
			Auth::logout();
			DB::disconnect('mysql');
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');
			DB::disconnect('mysql_4');

            return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }

    public function Header()
    {
    }

    public function Footer()
    {
		//Position at 1.5 cm from bottom
        $this->fpdf->SetY(-90);
        //Arial italic 8
        $this->fpdf->SetFont('Arial','I',8);
        //Page number
        $this->fpdf->Cell(95,68,'',1,0,'C',0);
        $this->fpdf->Ln(1);
        $this->fpdf->Cell(20,4,'Please transfer your payment to :',0,0,'L',0);
        $this->fpdf->SetFont('Arial','I',8);
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(20,4,'PT. Atlasat Solusindo',0,0,'L',0);
        $this->fpdf->Ln(6);

        $this->fpdf->Cell(20,4,'1. BCA  KCU Sudirman',0,1,'L',0);
        $this->fpdf->Cell(20,4,'     A/C NO : 035-319-151-6',0,1,'L',0);
        $this->fpdf->Ln(1);
        
        $this->fpdf->Cell(20,4,'2. BNI KCP Plaza Semanggi Setia Budi',0,1,'L',0);
        $this->fpdf->Cell(20,4,'     A/C NO : 07.238.30611',0,1,'L',0);
        $this->fpdf->Ln(1);

        $this->fpdf->Cell(20,4,'3. Bank Danamon Cabang Menara Bank Danamon',0,1,'L',0);
        $this->fpdf->Cell(20,4,'     A/C NO : 00359.540.4975',0,1,'L',0);
        $this->fpdf->Ln(1);

        $this->fpdf->Cell(20,4,'4. BTN KC Jakarta Harmoni',0,1,'L',0);
        $this->fpdf->Cell(20,4,'     A/C NO : 00014.01.30.002025.0',0,1,'L',0);
        $this->fpdf->Ln(1);

        $this->fpdf->Cell(20,4,'5. Bank UOB KC UOB Plaza',0,1,'L',0);
        $this->fpdf->Cell(20,4,'     A/C NO : 327.303.983.8',0,1,'L',0);
        $this->fpdf->Ln(1);

        $this->fpdf->Cell(20,4,'6. Bank Mandiri Cabang RS Jakarta',0,1,'L',0);
        $this->fpdf->Cell(20,4,'     A/C NO : 102.00.0750791.3',0,1,'L',0);

        $this->fpdf->SetFont('Times','I',10);
        $this->fpdf->SetXY(115,251);
        $this->fpdf->MultiCell(90,4,'To avoid automatic disconection by the system, please pay the Amount Due before Due Date, on every 25th of the month.

        (Mohon Pembayaran dilakukan selambat-lambatnya tanggal 25 setiap bulannya agar tidak terblokir secara otomatis)',1);
    }

    function SetCol($col)
    {
        //Set position at a given column
        $this->fpdf->col=$col;
        $x=10+$col*65;
        $this->fpdf->SetLeftMargin($x);
        $this->fpdf->SetX($x);
    }

    public function ChapterTitle($custno,$period,$report_date,$customerno,$customername,$amountdue,$duedate,$bsno,$laststatementdate,$vatno,$billingaddress1,$billingaddress2,$billingaddress3,$billingaddress4,$billingaddress5,$zipcode,$phone1,$previousbalance,$balanceadj,$previouspay,$totrefund,$prevbalance,$charge,$monthly,$totalusage,$usageadj,$totdiscount,$beforevat,$totalvat,$totalamount) 
    {
        $this->fpdf->Image('./images/logo-01.jpg',8,6,25);	

        $this->fpdf->SetFillColor(255,255,255);	
        //Title
        $this->fpdf->SetLineWidth(0.1);	
        $this->fpdf->Line(10.9, 30, 205.1, 30);
        $this->fpdf->SetLineWidth(0.2);	

        $this->fpdf->SetFont('times','B',8);
        $this->fpdf->Cell(0,3,'PT. ATLASAT SOLUSINDO',0,1,'R',0);
        $this->fpdf->Cell(0,3,'Plaza Central Lantai 21, ',0,1,'R',0);
        $this->fpdf->Cell(0,3,'Jl. Jendral Sudirman Kav 47',0,1,'R',0);
        $this->fpdf->SetFont('times','',8);
        //$this->fpdf->Cell(0,3,"Tlp : 62-21-5711788",0,1,'R',0);
        //$this->fpdf->Cell(0,3,"Fax : 62-21-5711769",0,1,'R',0);
        $this->fpdf->Cell(0,3,'Tlp : 62-21-2977 2977',0,1,'R',0);
        $this->fpdf->Cell(0,3,'Website : www.atlasat.co.id',0,1,'R',0);

        $this->fpdf->SetDrawColor(0,80,160);
        $this->fpdf->SetFillColor(230,230,0);
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont('times','B',10);
        $this->fpdf->Cell(130);
        $this->fpdf->Cell(30,7,'Due Date',1,0,'C',1);
        $this->fpdf->Cell(35,7,"20 ".strftime('%B %Y',strtotime($duedate)),1,0,'C',0);
        $this->fpdf->Cell(130);
        $this->fpdf->Ln(7);


        $this->fpdf->Cell(30,4,"$customername",0,0,'L',0);
        $this->fpdf->SetFont('times','',10);
        $this->fpdf->Ln(2);
        $this->fpdf->Cell(130);

        $this->fpdf->Cell(65,20,'',1,0,'C',0);
        $this->fpdf->Ln(5);
        $blank = '';

        $this->fpdf->Cell(131,4,"$billingaddress1",0,0,'L',0);
        $this->fpdf->Cell(25,4,'Statement No',0,0,'L',0);
        $this->fpdf->Cell(1,4,": $bsno",0,1,'L',0);
        $this->fpdf->Cell(131,4,"$billingaddress2",0,0,'L',0);
        $this->fpdf->Cell(25,4,'Statement Month',0,0,'L',0);
        $this->fpdf->Cell(1,4,": ".strftime('%B %Y',strtotime($laststatementdate)),0,1,'L',0);
        $this->fpdf->Cell(131,4,"$billingaddress3",0,0,'L',0);
        $this->fpdf->Cell(25,4,'Customer No',0,0,'L',0);
        $this->fpdf->Cell(1,4,": $customerno",0,1,'L',0);
        $this->fpdf->Cell(131,4,"$billingaddress4 $zipcode",0,0,'L',0);
        $this->fpdf->Cell(1,4," ",0,1,'L',0);
        $this->fpdf->Cell(131,4,"$billingaddress5",0,0,'L',0);
        $this->fpdf->Cell(1,4," ",0,1,'L',0);
        $this->fpdf->Cell(131,4,"$phone1",0,1,'L',0);
		//dd($phone1);
        $this->fpdf->ln(3); 
        $this->fpdf->Cell(40,10,'',1,0,'C',1);
        $this->fpdf->Cell(35,10,'',1,0,'C',1);
        $this->fpdf->Cell(60,10,'',1,0,'C',1);
        $this->fpdf->Cell(60,10,'',1,0,'C',1);

        $this->fpdf->Ln(1);
        $this->fpdf->Cell(40,2,'Saldo Sebelumnya',0,0,'C',0);
        $this->fpdf->Cell(35,2,'Pembayaran',0,0,'C',0);
        $this->fpdf->Cell(60,2,'Biaya Pemakaian Bulan Ini',0,0,'C',0);
        $this->fpdf->Cell(60,2,'Biaya Yang Harus Dibayar',0,0,'C',0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('times','BI',8);
        $this->fpdf->Cell(40,4,'Previous Balance',0,0,'C',0);
        $this->fpdf->Cell(35,4,'Payments and Credit',0,0,'C',0);
        $this->fpdf->Cell(60,4,'Charges and Debits',0,0,'C',0);
        $this->fpdf->Cell(60,4,'Balance Due',0,0,'C',0);
        $this->fpdf->SetFont('times','B',10);

        $this->fpdf->Ln(6);
        $this->fpdf->Cell(40,5,number_format("$previousbalance"),1,0,'R',0);
        if ($previouspay < 0) {
            $previouspay1 = '('.number_format($previouspay*-1).')';
        } else {
            $previouspay1 = number_format("$previouspay");
        }	
        $this->fpdf->Cell(35,5,$previouspay1,1,0,'R',0);
        $this->fpdf->Cell(60,5,number_format("$charge"),1,0,'R',0);
        $this->fpdf->Cell(60,5,number_format("$amountdue"),1,0,'R',0);
        $this->fpdf->Ln(6);

        $this->fpdf->Cell(100,10,'',1,0,'C',1);
        $this->fpdf->Cell(35,10,'',1,0,'C',1);
        $this->fpdf->Cell(60,10,'',1,0,'C',1);

        $this->fpdf->Ln(1);
        $this->fpdf->Cell(100,2,'Keterangan',0,0,'L',0);
        $this->fpdf->Cell(35,2,'Jumlah',0,0,'R',0);
        $this->fpdf->Cell(2);
        $this->fpdf->Cell(60,2,"Highlight",0,1,'C',0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('times','BI',8);
        $this->fpdf->Cell(100,4,'Description',0,0,'L',0);
        $this->fpdf->Cell(35,4,'Amount',0,0,'R',0);
        $this->fpdf->SetFont('times','',10);
        $this->fpdf->Ln(7);
        
        $sign = '';
        $this->fpdf->Cell(100,5,'Previous Balance',0,0,'L',0);
        $this->fpdf->Cell(25,5,number_format("$previousbalance"),0,0,'R',0);
        $this->fpdf->Cell(5,4,$sign,0,1,'L',0);
        
        $totalusage = 0;

		
        $bs_detail = M_BS_Detail_Postpaid::query()
                    ->where('CUSTOMERNO', $custno)
                    ->where('PERIOD', $period)
                    ->where('PRSS_ID', 0)
                    ->where('DESCRIPTION', '!=', 'PPN')
                    ->select('BD_ID', 'DESCRIPTION','PERIOD_SERVICE','AMOUNT')
                    ->orderBy('BD_ID','asc')
                    ->get();
        
        foreach($bs_detail as $bsd_id) 
        {
            $description = $bsd_id->DESCRIPTION;
            $periodservice = $bsd_id->PERIOD_SERVICE;
            $totalamt = $bsd_id->AMOUNT;
            
            if ($periodservice == '') 
            {
                $this->fpdf->Cell(100,4,$description,0,0,'L',0);
            } 
            else 
            {
                $this->fpdf->Cell(100,4,$description.' - '.$periodservice,0,0,'L',0);
            }

            if ($totalamt < 0) 
            { 
                $totalamt = ($totalamt * -1);
                $sign = 'CR';
            } 
            else 
            {
                $totalamt = $totalamt;
                $sign = '';
            }
                
            $this->fpdf->Cell(25,4,number_format("$totalamt"),0,0,'R',0);
            $this->fpdf->Cell(5,4,$sign,0,1,'L',0);
            $totalusage = $totalusage + $totalamt;
            $sign = '';
        }
		
		
        $this->fpdf->Cell(100,5,'',0,0,'L',0);
        $this->fpdf->Cell(25,5,'',0,0,'R',0);
        $this->fpdf->Cell(5,4,'',0,1,'L',0);

        $query1 = DB::table('bs_postpaid_detail')
                    ->where('CUSTOMERNO', $custno)
                    ->where('PERIOD', $period)
                    ->where('PRSS_ID', 18)
                    ->select(DB::raw('COUNT(1) AS counts'),'PERIOD_SERVICE')
					->groupBy('PERIOD_SERVICE')
                    ->get();
        //dd($query1[0]->counts);
        
        if ($query1[0]->counts > 0)
        {
            $periodservices = $query1[0]->PERIOD_SERVICE;
			
            $this->fpdf->SetFont('times','B',10);
            $this->fpdf->Cell(100,5,'Period : '.$periodservices,0,0,'L',0);
            $this->fpdf->Cell(25,5,'',0,0,'R',0);
            $this->fpdf->Cell(5,4,'',0,1,'L',0);
            $this->fpdf->SetFont('times','',10);
			
			$this->fpdf->Cell(100,5,'',0,0,'L',0);
			$this->fpdf->Cell(25,5,'',0,0,'R',0);
			$this->fpdf->Cell(5,4,'',0,1,'L',0);

            $bs_detail1 = M_BS_Detail_Postpaid::query()
                        ->where('CUSTOMERNO', $custno)
                        ->where('PERIOD', $period)
                        ->where('PRSS_ID', 18)
                        ->select('BD_ID', 'DESCRIPTION','PERIOD_SERVICE','AMOUNT')
                        ->orderBy('BD_ID','asc')
                        ->get();

            foreach($bs_detail1 as $bsd_id1)
            {
                $description = $bsd_id1->DESCRIPTION;
                $periodservice = $bsd_id1->PERIOD_SERVICE;
                $totalamt = $bsd_id1->AMOUNT;
                
                $this->fpdf->Cell(100,4,$description,0,0,'L',0);
				//$this->fpdf->Cell(100,4,$description.' - '.$periodservice,0,0,'L',0);

                if ($totalamt < 0) 
                { 
                    $totalamt = ($totalamt * -1);
                    $sign = 'CR';
                } 
                else 
                {
                    $totalamt = $totalamt;
                    $sign = '';
                }
                    
                $this->fpdf->Cell(25,4,number_format("$totalamt"),0,0,'R',0);
                $this->fpdf->Cell(5,4,$sign,0,1,'L',0);
                $totalusage = $totalusage + $totalamt;
                $sign = '';
            }

            $this->fpdf->Cell(100,5,'',0,0,'L',0);
            $this->fpdf->Cell(25,5,'',0,0,'R',0);
            $this->fpdf->Cell(5,4,'',0,1,'L',0);
        }
        
        $bs_detail2 = M_BS_Detail_Postpaid::query()
                    ->where('CUSTOMERNO', $custno)
                    ->where('PERIOD', $period)
                    ->where('PRSS_ID', 0)
                    ->where('DESCRIPTION', 'PPN')
                    ->select('BD_ID', 'DESCRIPTION','PERIOD_SERVICE','AMOUNT')
                    ->orderBy('BD_ID','asc')
                    ->get();

        foreach($bs_detail2 as $bsd_id2)
        {
            $description = $bsd_id2->DESCRIPTION;
            $periodservice = $bsd_id2->PERIOD_SERVICE;
            $totalamt = $bsd_id2->AMOUNT;
            
            $this->fpdf->Cell(100,4,$description,0,0,'L',0);

            if ($totalamt < 0) 
            { 
                $totalamt = ($totalamt * -1);
                $sign = 'CR';
            } 
            else 
            {
                $totalamt = $totalamt;
                $sign = '';
            }
                
            $this->fpdf->Cell(25,4,number_format("$totalamt"),0,0,'R',0);
            $this->fpdf->Cell(5,4,$sign,0,1,'L',0);
            $totalusage = $totalusage + $totalamt;
            $sign = '';
        }

        $this->fpdf->Cell(100);
        $this->fpdf->Cell(25,0,'',1,1,'',1);

        $this->fpdf->Cell(100,5,'',0,0,'L',0);
        $this->fpdf->Cell(25,5,'',0,0,'R',0);
        $this->fpdf->Cell(5,4,'',0,1,'L',0);
        
        $this->fpdf->SetFont('times','B',10);
        $this->fpdf->Cell(100,4,'Balance Due',0,0,'L',0);
        $this->fpdf->Cell(25,4,number_format("$amountdue"),0,0,'R',0);
        $this->fpdf->Cell(5,4,$sign,0,1,'L',0);
        $this->fpdf->SetFont('times','',10);
        $this->fpdf->ln(2);
        $this->fpdf->Cell(130,0,'',1,1,'',1);
        
        $this->fpdf->ln(2);
        $this->fpdf->SetFont('times','B',14);
        $this->fpdf->SetFont('times','',10);
        
        $PHONE = DB::select('SELECT BR_PHONE FROM branch WHERE BR_KODE = "IDN" ;');
        //dd($PHONE[0]->BR_PHONE);
        //foreach($PHONE[0]->BR_PHONE as $PHONES)
        //{
            $br_phone = $PHONE[0]->BR_PHONE;
        //}

        $this->fpdf->SetXY(145,100);

        $this->fpdf->MultiCell(60,4,"Dear valued ATS customers, Should you need any information regarding revision or changes of your Billing Statements or Invoices. Kindly contact our Customer Care 24 hour by stating your Customers ID :
        Phone : ".$br_phone."
        Email : cs@atlasat.co.id",1);
        
        $this->fpdf->SetXY(145,135);
        $this->fpdf->MultiCell(60,4,"Pelanggan Atlasat yang terhormat, Jika memerlukan informasi dan perubahan mengenai Billing Statement dan Faktur Pajak, Anda dapat menghubungi Customer Care 24 jam kami, dengan menyebutkan Customers ID, melalui:
        Phone : ".$br_phone."
        Email : cs@atlasat.co.id",1);
    }

    public function PrintChapter($custno,$period,$report_date,$customerno,$customername,$amountdue,$duedate,$bsno,$laststatementdate,$vatno,$billingaddress1,$billingaddress2,$billingaddress3,$billingaddress4,$billingaddress5,$zipcode,$phone1,$previousbalance,$balanceadj,$previouspay,$totrefund,$prevbalance,$charge,$monthly,$totalusage,$usageadj,$totdiscount,$beforevat,$totalvat,$totalamount)	
    {
        
        $this->fpdf->AddPage();
        $this->ChapterTitle($custno,$period,$report_date,$customerno,$customername,$amountdue,$duedate,$bsno,$laststatementdate,$vatno,$billingaddress1,$billingaddress2,$billingaddress3,$billingaddress4,$billingaddress5,$zipcode,$phone1,$previousbalance,$balanceadj,$previouspay,$totrefund,$prevbalance,$charge,$monthly,$totalusage,$usageadj,$totdiscount,$beforevat,$totalvat,$totalamount);	
        
    }
}
