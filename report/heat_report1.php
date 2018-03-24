<?php
/**
 * User: stiff
 * Date: 20.02.2017
 * Time: 14:57
 */
require_once( "tfpdf/tfpdf.php" );
define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");
class PDF extends tFPDF
{
    function Header()
    {
        $heat = $_GET['heat'];
        //$this->Image('logo_pb.png',10,8,33);
        $this->AddFont('Arial','','arial.ttf',true);
        $this->SetFont('Arial','',10);
        $this->SetTitle('EAF-3 Heat report level 2');
        $this->Cell(40,8,'БМЗ ДСП-3','TL',0,'C');
        $this->Cell(110,8,'АВТОМАТИЗАЦИЯ ПРОИЗВОДСТВА УРОВЕНЬ-2','T',0,'C');
        $this->Cell(40,8,'Стр. '.$this->PageNo().'/{nb}','TR',0,'C');
        $this->Ln();
        $this->SetFont('Arial','',12);
        $this->Cell(40,6,'№ плавки: '.$heat,'BL',0,'C');
        $this->Cell(110,6,'Отчёт о плавке','B',0,'C');
        $this->SetFont('Arial','',8);
        $this->Cell(40,6,'выдан '.date("d.m.y H:i"),'BR',0,'C');
        $this->Ln();
    }
    function Footer()
    {
        //$this->Cell(190,0,'','T',0,'');
    }
}
$heat = $_GET['heat'];

$pdf=new PDF( 'P', 'mm', 'A4' );
$pdf->AliasNbPages();
$pdf->AddPage();
$heatin=0;

if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select count(heatid) HCNT from heat where heatid='$heat'");
    oci_execute($s);
    while (oci_fetch($s)) {
        $heatin=oci_result($s, "HCNT");
    }
} else {
    $err = OCIError();
}

if ($heatin>0) {

if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select t.heatid,nvl(t.superintendent,' ') SUPERINTENDENT,nvl(t.foreman,' ') FOREMAN,nvl(to_char(t.heatstart,'dd.mm.yyyy hh24:mi'),' ') HEATSTART1,
nvl(h.analysisidact,' ') ANALYSISIDACT,nvl(t.ladleid,' ') LADLEID,nvl(t.heatsonladle,0) HEATSONLADLE,nvl(t.bottomlife,0) BOTTOMLIFE,nvl(t.lininglife,0) LININGLIFE,
nvl(t.rooflife,0) ROOFLIFE,nvl(t.tubelife,0) TUBELIFE,nvl(t.ctpcslife,0) CTPCSLIFE,nvl(t.electrodechangep1,' ') ELECTRODECHANGEP1,nvl(t.electrodechangep2,' ') ELECTRODECHANGEP2,
nvl(t.electrodechangep3,' ') ELECTRODECHANGEP3,nvl(t.remark,' ') REMARK,nvl(h.meltingprofile,0) MELTINGPROFILE,nvl(h.startcastrelplan,0) STARTCASTRELPLAN,
nvl(h.crewid,' ') CREWID,nvl(round(t.elen),0) ELEN,nvl(to_char(t.heatstart,'hh24:mi'),' ') HEATSTART,nvl(to_char(t.meltstart,'hh24:mi'),' ') MELTSTART,
nvl(round(t.durrep),0) DURREP,nvl(to_char(t.meltend,'hh24:mi'),' ') MELTEND,nvl(round(t.totmeltt),0) TOTMELTT,nvl(to_char(t.tapstart,'hh24:mi'),' ') TAPSTART,
nvl(to_char(t.tapend,'hh24:mi'),' ') TAPEND,nvl(round(t.durtap),0) DURTAP,nvl(to_char(t.heatend,'hh24:mi'),' ') HEATEND,
nvl(round(t.taptotap),0) TAPTOTAP,nvl(round(t.sum_pon),0) SUM_PON,(case t.inp when 0 then 0 else nvl(round((t.elen/(t.inp/1000)),2),0) end) SPEC_ELEN,
(case t.netsteelweight when 0 then 0 else nvl(round((t.elen/t.netsteelweight*1000),2),0) end) SPEC_ENER,nvl(round(t.netsteelweight/1000),0) NETSTEELWEIGHT,
nvl(round(t.hotheelact/1000,1),0) HOTHEELACT,(case t.inp when 0 then 0 else nvl(round((t.netsteelweight/t.inp*100),2),0) end) VIHOD,
nvl(t.sumargon,0) SUMARGON,nvl(t.sumnitrogen,0) SUMNITROGEN,nvl(t.sum_argon,0) SUM_ARGON,nvl(t.lime,0) LIME,nvl(t.feeding,0) FEEDING,
nvl(t.sum_doloinj,0) SUM_DOLOINJ,nvl(t.sum21,0) SUM21,nvl(t.sum22,0) SUM22,nvl(t.sum1,0) SUM1,nvl(t.sum23,0) SUM23,nvl(t.sum2,0) SUM2,
nvl(t.cokebrlm,0) COKEBRLM,nvl(t.sum25,0) SUM25,nvl(t.sum_oxyg,0) SUM_OXYG,nvl(t.sumgas,0) SUMGAS,nvl(t.sumcokebr,0) SUMCOKEBR
from heatreport t, heat h where t.heatidinternal=h.heatidinternal
and t.heatid='$heat'");
    oci_execute($s);
    while (oci_fetch($s)) {
        //$pdf->Write( 10, oci_result($s, "HEATID") );

$pdf->SetFont('Arial','',10);
$pdf->Cell(2,6,'','L',0,'');
$pdf->Cell(62,6,'Мастер: '.oci_result($s, "SUPERINTENDENT"),'',0,'L');
$pdf->Cell(62,6,'','',0,'');
$pdf->Cell(62,6,'Оператор: '.oci_result($s, "FOREMAN"),'',0,'R');
$pdf->Cell(2,6,'','R',0,'');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->Cell(2,6,'','LB',0,'');
$pdf->Cell(50,6,'Дата: '.oci_result($s, "HEATSTART1"),'B',0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,6,'Марка '.oci_result($s, "ANALYSISIDACT"),'B',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(25,6,'№ ковша '.oci_result($s, "LADLEID"),'B',0,'R');
$pdf->Cell(33,6,'Пл. на ковш '.oci_result($s, "HEATSONLADLE"),'BR',0,'R');
$pdf->Ln();

$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Износ','',0,'L');
$pdf->Cell(15,5,'Подино','',0,'C');
$pdf->Cell(15,5,'Стенка','',0,'C');
$pdf->Cell(15,5,'Свод','',0,'C');
$pdf->Cell(15,5,'Эркер','',0,'C');
$pdf->Cell(25,5,'Малый свод','',0,'C');
$pdf->Cell(38,5,'Фаза','L',0,'C');
$pdf->Cell(15,5,'I','',0,'C');
$pdf->Cell(15,5,'II','',0,'C');
$pdf->Cell(15,5,'III','R',0,'C');
$pdf->Ln();
$pdf->Cell(2,5,'','LB',0,'');
$pdf->Cell(20,5,'плавок','B',0,'L');
$pdf->Cell(15,5,oci_result($s, "BOTTOMLIFE"),'B',0,'C');
$pdf->Cell(15,5,oci_result($s, "LININGLIFE"),'B',0,'C');
$pdf->Cell(15,5,oci_result($s, "ROOFLIFE"),'B',0,'C');
$pdf->Cell(15,5,oci_result($s, "TUBELIFE"),'B',0,'C');
$pdf->Cell(25,5,oci_result($s, "CTPCSLIFE"),'B',0,'C');
$pdf->Cell(38,5,'Смена электродов','LB',0,'C');
$pdf->Cell(15,5,oci_result($s, "ELECTRODECHANGEP1"),'B',0,'C');
$pdf->Cell(15,5,oci_result($s, "ELECTRODECHANGEP2"),'B',0,'C');
$pdf->Cell(15,5,oci_result($s, "ELECTRODECHANGEP3"),'BR',0,'C');
$pdf->Ln();

$pdf->AddFont('Arial Bold','','arialbd.ttf',true);
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(188,5,'Замечания '.oci_result($s, "REMARK"),'R',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','LB',0,'');
$pdf->Cell(62,5,'Профиль плавления: '.oci_result($s, "MELTINGPROFILE"),'B',0,'C');
$pdf->Cell(62,5,'Профиль СИМЕЛТ: '.oci_result($s, "STARTCASTRELPLAN"),'B',0,'C');
$pdf->Cell(62,5,'Профиль MORE: '.oci_result($s, "CREWID"),'B',0,'C');
$pdf->Cell(2,5,'','BR',0,'');
$pdf->Ln();

$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Время','',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(15,5,'Начало','',0,'C');
$pdf->Cell(15,5,'Конец','',0,'C');
$pdf->Cell(15,5,'Прод.','',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(25,5,'Актив. эл. эн.','',0,'L');
$pdf->Cell(20,5,oci_result($s, "ELEN"),'',0,'R');
$pdf->Cell(74,5,' [кВтч]','R',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'','',0,'L');
$pdf->Cell(15,5,'','',0,'C');
$pdf->Cell(15,5,'','',0,'C');
$pdf->Cell(15,5,'','',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(25,5,'Удельн. эл. эн.','',0,'L');
$pdf->Cell(20,5,oci_result($s, "SPEC_ELEN"),'',0,'R');
$pdf->Cell(74,5,' ('.oci_result($s, "SPEC_ENER").') [кВтч]','R',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Заправка','',0,'L');
$pdf->Cell(15,5,oci_result($s, "HEATSTART"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "MELTSTART"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "DURREP"),'',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(25,5,'Вес нетто стали','',0,'L');
$pdf->Cell(20,5,oci_result($s, "NETSTEELWEIGHT"),'',0,'R');
$pdf->Cell(74,5,' [т]','R',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Плавление','',0,'L');
$pdf->Cell(15,5,oci_result($s, "MELTSTART"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "MELTEND"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "TOTMELTT"),'',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(25,5,'Болото','',0,'L');
$pdf->Cell(20,5,oci_result($s, "HOTHEELACT"),'',0,'R');
$pdf->Cell(74,5,' [т]','R',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Выпуск','',0,'L');
$pdf->Cell(15,5,oci_result($s, "TAPSTART"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "TAPEND"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "DURTAP"),'',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','LB',0,'');
$pdf->Cell(25,5,'Выход','B',0,'L');
$pdf->Cell(20,5,oci_result($s, "VIHOD"),'B',0,'R');
$pdf->Cell(74,5,' [%]','RB',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Плавка','',0,'L');
$pdf->Cell(15,5,oci_result($s, "HEATSTART"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "HEATEND"),'',0,'C');
$pdf->Cell(15,5,oci_result($s, "TAPTOTAP"),'',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(25,5,'','',0,'L');
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(20,5,'Аргон','',0,'C');
$pdf->Cell(20,5,'Азот','',0,'C');
$pdf->Cell(20,5,'Ковш','',0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(34,5,'','R',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','LB',0,'');
$pdf->Cell(35,5,'Время под током','B',0,'L');
$pdf->Cell(15,5,'','B',0,'C');
$pdf->Cell(15,5,oci_result($s, "SUM_PON"),'B',0,'R');
$pdf->Cell(2,5,'','B',0,'');
$pdf->Cell(2,5,'','LB',0,'');
$pdf->Cell(25,5,'Продувка','B',0,'L');
$pdf->Cell(20,5,oci_result($s, "SUMARGON"),'B',0,'C');
$pdf->Cell(20,5,oci_result($s, "SUMNITROGEN"),'B',0,'C');
$pdf->Cell(20,5,oci_result($s, "SUM_ARGON"),'B',0,'C');
$pdf->Cell(34,5,'[Nl]','RB',0,'L');
$pdf->Ln();

$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Подача','',0,'L');
$pdf->Cell(15,5,'','',0,'C');
$pdf->Cell(15,5,'','',0,'C');
$pdf->Cell(15,5,'','',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(31,5,'','',0,'L');
$pdf->Cell(22,5,'О2 горения','',0,'C');
$pdf->Cell(22,5,'О2 вдувания','',0,'C');
$pdf->Cell(22,5,'Газ','',0,'C');
$pdf->Cell(22,5,'Кокс','R',0,'C');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'','',0,'L');
$pdf->Cell(15,5,'','',0,'C');
$pdf->Cell(15,5,'','',0,'C');
$pdf->Cell(15,5,'','',0,'R');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(31,5,'Инжекторная горелка','',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(22,5,oci_result($s, "SUM21"),'',0,'C');
$pdf->Cell(22,5,oci_result($s, "SUM22"),'',0,'C');
$pdf->Cell(22,5,oci_result($s, "SUM1"),'',0,'C');
$pdf->Cell(22,5,'-','R',0,'C');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(35,5,'Известь (подача)','',0,'L');
$pdf->Cell(15,5,oci_result($s, "LIME"),'',0,'C');
$pdf->Cell(15,5,'[кг]','',0,'C');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(31,5,'Углеродная горелка','',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(22,5,oci_result($s, "SUM23"),'',0,'C');
$pdf->Cell(22,5,'-','',0,'C');
$pdf->Cell(22,5,oci_result($s, "SUM2"),'',0,'C');
$pdf->Cell(22,5,oci_result($s, "COKEBRLM"),'R',0,'C');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(35,5,'ОКАТЫШИ','',0,'L');
$pdf->Cell(15,5,oci_result($s, "FEEDING"),'',0,'C');
$pdf->Cell(15,5,'[т]','',0,'C');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(31,5,'Копьё','',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(22,5,'-','',0,'C');
$pdf->Cell(22,5,oci_result($s, "SUM25"),'',0,'C');
$pdf->Cell(22,5,'-','',0,'C');
$pdf->Cell(22,5,'-','R',0,'C');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(35,5,'Порошок (вдувание)','',0,'L');
$pdf->Cell(15,5,oci_result($s, "SUM_DOLOINJ"),'',0,'C');
$pdf->Cell(15,5,'[кг]','',0,'C');
$pdf->Cell(2,5,'','',0,'');
$pdf->Cell(2,5,'','L',0,'');
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(31,5,'Всего','',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(44,5,oci_result($s, "SUM_OXYG"),'',0,'C');
$pdf->Cell(22,5,oci_result($s, "SUMGAS"),'',0,'C');
$pdf->Cell(22,5,oci_result($s, "SUMCOKEBR"),'R',0,'C');
$pdf->Ln();
$pdf->Cell(2,4,'','LB',0,'');
$pdf->Cell(35,4,'','B',0,'L');
$pdf->Cell(15,4,'','B',0,'C');
$pdf->Cell(15,4,'','B',0,'C');
$pdf->Cell(2,4,'','B',0,'');
$pdf->Cell(2,4,'','LB',0,'');
$pdf->Cell(31,4,'','B',0,'L');
$pdf->Cell(44,4,'[Nm3]','B',0,'C');
$pdf->Cell(22,4,'[Nm3]','B',0,'C');
$pdf->Cell(22,4,'[кг]','RB',0,'C');
$pdf->Ln();
    }
} else {
    $err = OCIError();
}

$pdf->Cell(2,1,'','',0,'');
$pdf->Ln();

$y=$pdf->GetY();
$ves=0;
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select b.bucketsequence BUCKETSEQUENCE,b.bucketno BUCKETNO,
to_char(b.chargingtime,'hh24:mi') CHARGINGTIME from bucket b, heat h, heatbucket hb
where h.heatidinternal=hb.heatidinternal and hb.rnobucket=b.rnobucket and h.heatid='$heat'");
    oci_execute($s);
    while (oci_fetch($s)) {
        $buck=oci_result($s, "BUCKETNO");
        $pdf->Cell(2,5,'','LT',0,'');
        $pdf->Cell(8,5,'№№','T',0,'C');
        $pdf->Cell(10,5,'Корзина','T',0,'C');
        $pdf->Cell(15,5,'Время','T',0,'C');
        //$pdf->Ln();
        //$pdf->Cell(2,6,'','L',0,'');
        $pdf->Cell(10,5,'Слой','LT',0,'C');
        $pdf->Cell(55,5,'Материал','T',0,'L');
        $pdf->Cell(15,5,'Вес [кг]','TR',0,'L');
        $pdf->Ln();
        $pdf->Cell(2,5,'','L',0,'');
        $pdf->Cell(8,5,oci_result($s, "BUCKETSEQUENCE"),'',0,'C');
        $pdf->Cell(10,5,'№ '.oci_result($s, "BUCKETNO"),'',0,'C');
        $pdf->Cell(15,5,oci_result($s, "CHARGINGTIME"),'',0,'C');
        //$pdf->Ln();
        $ib=0;
        if ($c2 = OCILogon("login", "pass", "oracle","AL32UTF8")) {
            $s2 = OCIParse($c2, "select bm.materialsequence MATERIALSEQUENCE,m.longname SHORTNAME,sum(bm.weightact) WEIGHT
from bucket b,heatbucket hb,bucketmaterial bm,ss_materialdefinition m, heat h
where h.heatidinternal=hb.heatidinternal and hb.rnobucket=b.rnobucket and b.rnobucmat=bm.rnobucmat and bm.materialid=m.materialidl2 and h.heatid='$heat'
and b.bucketno='$buck' group by m.longname,bm.materialsequence order by bm.materialsequence,m.longname");
            oci_execute($s2);
            while (oci_fetch($s2)) {
                if ($ib!=0) {
                    $pdf->Cell(35,5,'','L',0,'');
                }
                $pdf->Cell(10,5,oci_result($s2, "MATERIALSEQUENCE"),'L',0,'C');
                $pdf->Cell(55,5,oci_result($s2, "SHORTNAME"),'',0,'L');
                $pdf->Cell(15,5,oci_result($s2, "WEIGHT"),'R',0,'L');
                $pdf->Ln();
                $ib=$ib+1;
                $ves=$ves+oci_result($s2, "WEIGHT");
            }
            } else {
                $err2 = OCIError();
            }
    }
} else {
    $err = OCIError();
}
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(35,5,'','LBT',0,'');
$pdf->Cell(10,5,'','LBT',0,'');
$pdf->Cell(55,5,'Скрап','BT',0,'L');
$pdf->Cell(15,5,$ves,'BRT',0,'L');
$pdf->Ln();

$pdf->Cell(2,1,'','',0,'');
$pdf->Ln();

    $y2=$pdf->GetY();
    $pdf->SetXY(127,$y);
    $pdf->Cell(38,5,'Скрап','LT',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(15,5,'Код Гефест','T',0,'C');
    $pdf->Cell(20,5,'[кг]','RT',0,'C');
    $pdf->Ln();
    $pdf->SetX(127);
    if ($c2 = OCILogon("login", "pass", "oracle","AL32UTF8")) {
        $s2 = OCIParse($c2, "select m.shortname SHORTN,m.materialidl3 GEFEST,sum(bm.weightact) WEIGHT
from bucket b,heatbucket hb,bucketmaterial bm,ss_materialdefinition m, heat h
where h.heatidinternal=hb.heatidinternal and hb.rnobucket=b.rnobucket and b.rnobucmat=bm.rnobucmat
and bm.materialid=m.materialidl2 and h.heatid='$heat'
group by m.longname,m.shortname,m.materialidl3 order by m.shortname");
        oci_execute($s2);
        while (oci_fetch($s2)) {
            $pdf->Cell(38,5,oci_result($s2, "SHORTN"),'L',0,'C');
            $pdf->Cell(15,5,oci_result($s2, "GEFEST"),'',0,'C');
            $pdf->Cell(20,5,oci_result($s2, "WEIGHT"),'R',0,'C');
            $pdf->Ln();
            $pdf->SetX(127);
        }
    } else {
        $err2 = OCIError();
    }
    $pdf->Cell(73,0,'','T',0,'');
    $pdf->SetXY(10,$y2);
    $y=$pdf->GetY();

$pdf->Cell(2,5,'','LT',0,'');
    $pdf->SetFont('Arial Bold','',8);
$pdf->Cell(30,5,'Добавки','T',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,5,'Код Гефест','T',0,'C');
$pdf->Cell(16,5,'[кг]','RT',0,'C');
$pdf->Ln();
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select m.shortname MAT,m.materialidl3 GEFEST,sum(ham.value) WEIGHT
from heatadditionmaterial ham, heataddition ha, heat h, ss_materialdefinition m
where h.heatidinternal=ha.heatidinternal and ha.rnoaddition=ham.rnoaddition and ham.materialid=m.materialidl2
and ha.valuetype='DV' and h.heatid='$heat' group by m.materialidl3,m.shortname order by m.shortname");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->Cell(2,5,'','L',0,'');
        $pdf->Cell(30,5,oci_result($s, "MAT"),'',0,'L');
        $pdf->Cell(20,5,oci_result($s, "GEFEST"),'',0,'C');
        $pdf->Cell(16,5,oci_result($s, "WEIGHT"),'R',0,'C');
        $pdf->Ln();
    }
} else {
    $err = OCIError();
}

$pdf->Cell(68,1,'','T',0,'');
$pdf->Ln();
$y2=$pdf->GetY();

$pdf->SetXY(80,$y);
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(2,5,'','LT',0,'');
$pdf->Cell(116,5,'Замеры температуры','T',0,'C');
$pdf->Cell(2,5,'','RT',0,'');
$pdf->Ln();
$pdf->SetX(80);
$pdf->Cell(6,5,'','L',0,'');
$pdf->Cell(20,5,'Время','',0,'C');
$pdf->Cell(20,5,'Замер','',0,'C');
$pdf->Cell(12,5,'O2','',0,'C');
$pdf->Cell(20,5,'C','',0,'C');
$pdf->Cell(20,5,'Al Celox','',0,'C');
$pdf->Cell(20,5,'Место','',0,'C');
$pdf->Cell(2,5,'','R',0,'');
$pdf->Ln();
$pdf->SetX(80);
$pdf->SetFont('Arial','',8);
$ic=1;
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select to_char(hm.measuredtime,'hh24:mi') MESTIME,hm.measuredtemp TEMPER, nvl(to_char(hm.measuredoxygen),'-') O2,
nvl(to_char(hm.measuredcarbon),'-') CARB, nvl(to_char(round((105*(0.4545+0.001574*hm.measuredoxygen)),2)),'-') AL,
(case hm.measurementtype when 'DM' then 'ПЕЧЬ' when 'BM' then 'КОВШ' when 'EM' then 'CELOX' else ' ' end) TYPE
from heatmeasurement hm, heat h where hm.heatidinternal=h.heatidinternal and h.heatid='$heat' order by hm.measuredtime");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->Cell(2,5,'','L',0,'');
        $pdf->Cell(4,5,$ic,'',0,'');
        $pdf->Cell(20,5,oci_result($s, "MESTIME"),'',0,'C');
        $pdf->Cell(20,5,oci_result($s, "TEMPER"),'',0,'C');
        $pdf->Cell(12,5,oci_result($s, "O2"),'',0,'C');
        $pdf->Cell(20,5,oci_result($s, "CARB"),'',0,'C');
        $pdf->Cell(20,5,oci_result($s, "AL"),'',0,'C');
        $pdf->Cell(20,5,oci_result($s, "TYPE"),'',0,'C');
        $pdf->Cell(2,5,'','R',0,'');
        $pdf->Ln();
        $pdf->SetX(80);
        $ic=$ic+1;
    }
} else {
    $err = OCIError();
}
$pdf->Cell(120,1,'','T',0,'');
$pdf->Ln();
$pdf->SetXY(10,$y2);

    $pdf->AddPage();
    $pdf->SetFont('Arial Bold','',8);
    $pdf->Cell(190,2,'','B',0,'');
    $pdf->Ln();

$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(2,5,'','LTB',0,'');
$pdf->Cell(186,5,'Химанализ','TB',0,'L');
$pdf->Cell(2,5,'','RTB',0,'');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Рекоменд.','',0,'L');
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select ga.element ELEM, to_char(nvl(ga.valuemin,0),'0.000') MINE, to_char(nvl(ga.valuemax,0),'0.000') MAXE
from heatsteelgradeanalysis ga, displayorder do, heat h
where h.heatidinternal=ga.heatidinternal and ga.element=do.element and h.heatid='$heat'
order by do.heatsteelanalysissequence");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->Cell(10,5,oci_result($s, "ELEM"),'',0,'C');
    }
} else {
    $err = OCIError();
}
$pdf->SetX(190);
$pdf->Cell(0,5,'','R',0,'');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Min','',0,'L');
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select ga.element ELEM, to_char(nvl(ga.valuemin,0),'0.000') MINE, to_char(nvl(ga.valuemax,0),'0.000') MAXE
from heatsteelgradeanalysis ga, displayorder do, heat h
where h.heatidinternal=ga.heatidinternal and ga.element=do.element and h.heatid='$heat'
order by do.heatsteelanalysissequence");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->Cell(10,5,oci_result($s, "MINE"),'',0,'C');
    }
} else {
    $err = OCIError();
}
$pdf->SetX(190);
$pdf->Cell(0,5,'','R',0,'');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Max','',0,'L');
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select ga.element ELEM, to_char(nvl(ga.valuemin,0),'0.000') MINE, to_char(nvl(ga.valuemax,0),'0.000') MAXE
from heatsteelgradeanalysis ga, displayorder do, heat h
where h.heatidinternal=ga.heatidinternal and ga.element=do.element and h.heatid='$heat'
order by do.heatsteelanalysissequence");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->Cell(10,5,oci_result($s, "MAXE"),'',0,'С');
    }
} else {
    $err = OCIError();
}
$pdf->SetX(190);
$pdf->Cell(0,5,'','R',0,'');
$pdf->Ln();
$pdf->Cell(190,0,'','T',0,'');
$pdf->Ln();

$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Проба','',0,'L');
$pdf->SetX(190);
$pdf->Cell(0,5,'','R',0,'');
$pdf->Ln();
$ip=0;
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select (case hs.sampleplace when 1 then 'A3' when 4 then 'B3' else 'Z3' end)||hs.samplenumber SAMPLE,
to_char(hs.analysedtime,'hh24:mi') TIMES,hs.rnosample PROBA from heatsample hs, heat h
where h.heatidinternal=hs.heatidinternal and h.heatid='$heat' order by hs.analysedtime");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->SetFont('Arial','',7);
        $proba=oci_result($s, "PROBA");
        $pdf->Cell(2,5,'','L',0,'');
        $pdf->Cell(10,5,oci_result($s, "TIMES"),'',0,'С');
        $pdf->SetFont('Arial Bold','',7);
        $pdf->Cell(10,5,oci_result($s, "SAMPLE"),'',0,'С');
        $pdf->SetFont('Arial','',7);
        //$y2=$pdf->GetY();
        if ($c2 = OCILogon("login", "pass", "oracle","AL32UTF8")) {
            $s2 = OCIParse($c2, "select ha.element ELEM, to_char(ha.value,'0.000') VAL from heatsample hs, heatanalysis ha, displayorder do
                              where hs.rnosample=ha.rnosample and ha.element=do.element(+) and hs.rnosample='$proba'
                              order by do.heatsteelanalysissequence");
            oci_execute($s2);
            while (oci_fetch($s2)) {
                $y2=$pdf->GetY();
                $x2=$pdf->GetX();
                $pdf->Cell(8,5,oci_result($s2, "VAL"),'',0,'С');
                if ($ip==0) {
                    $pdf->SetY($y2-5);
                    $pdf->SetX($x2);
                    $pdf->SetFont('Arial Bold','',7);
                    $pdf->Cell(9,5,oci_result($s2, "ELEM"),'',0,'C');
                    $pdf->SetFont('Arial','',7);
                    $pdf->SetY($y2);
                    $pdf->SetX($x2+8);
                }
            }
            $pdf->SetX(190);
            $pdf->Cell(0,5,'','R',0,'');
            $pdf->Ln();
        } else {
            $err2 = OCIError();
        }
        $ip=$ip+1;
    }
} else {
    $err = OCIError();
}
$pdf->Cell(190,0,'','T',0,'');
$pdf->Ln();


$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(190,2,'','B',0,'');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(188,5,'Простои:','R',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','L',0,'');
$pdf->Cell(20,5,'Начало','',0,'C');
$pdf->Cell(20,5,'Конец','',0,'C');
$pdf->Cell(50,5,'Тип','',0,'L');
$pdf->Cell(70,5,'Причина','',0,'L');
$pdf->Cell(28,5,'Примечание','R',0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select to_char(hd.start_time,'hh24:mi') DSTART,to_char(hd.end_time,'hh24:mi') DEND,
k.kd KD,r.rd RD,hd.description DESCR from heatdelay hd,
(select kind,description kd from delaycodespecification where reason is null) k,
(select kind,reason,description rd from delaycodespecification where reason is not null) r
where hd.codekind=k.kind and hd.codereason=r.reason and hd.codekind=r.kind
and hd.heat_name='$heat' order by hd.start_time");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->Cell(2,5,'','L',0,'');
        $pdf->Cell(20,5,oci_result($s, "DSTART"),'',0,'C');
        $pdf->Cell(20,5,oci_result($s, "DEND"),'',0,'C');
        $pdf->Cell(50,5,oci_result($s, "KD"),'',0,'L');
        $pdf->Cell(70,5,oci_result($s, "RD"),'',0,'L');
        $pdf->Cell(28,5,oci_result($s, "DESCR"),'R',0,'L');
        $pdf->Ln();
    }
} else {
    $err = OCIError();
}
$pdf->Cell(190,5,'','T',0,'');
$pdf->Ln();

    $pdf->AddPage();
$pdf->SetFont('Arial Bold','',8);
$pdf->Cell(2,5,'','TLB',0,'');
$pdf->Cell(188,5,'Хронометраж плавки','TRB',0,'L');
$pdf->Ln();
$pdf->Cell(2,5,'','LB',0,'');
$pdf->Cell(30,5,'Время','B',0,'L');
$pdf->Cell(4,5,'','LB',0,'');
$pdf->Cell(154,5,'Событие','RB',0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select log_time, LTIME, TEXT from
        (select l.log_time log_time, to_char(l.log_time,'hh24:mi') LTIME, l.text_other TEXT
        from tb_area_log l, heat h where l.log_time>h.heatstart and l.log_time<h.heatend
        and (l.area='LOG'and MSG_NUMBER in (207,208,224)) and h.heatid='$heat'
        union all
        select l.log_time log_time, substr(l.text_other,1,14) LTIME,substr(l.text_other,19) TEXT
        from tb_area_log l, heat h where h.heatidinternal=l.heatidinternal
        and l.area='HEATR' and h.heatid='$heat') order by log_time");
    oci_execute($s);
    while (oci_fetch($s)) {
        $pdf->Cell(2,5,'','L',0,'');
        $pdf->Cell(30,5,oci_result($s, "LTIME"),'R',0,'L');
        $pdf->Cell(4,5,'','',0,'');
        $pdf->Cell(154,5,oci_result($s, "TEXT"),'R',0,'L');
        $pdf->Ln();
    }
} else {
    $err = OCIError();
}
$pdf->Cell(190,0,'','T',0,'');
$pdf->Ln();
}
else {
    $pdf->Cell(190,5,'Данные по этой плавке отсутствуют.','',0,'L');
}
$pdf->Output( $heat.".pdf", "I" );
