<?php
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select (case hs.sampleplace when 1 then 'A3' when 4 then 'B3' else 'Z3' end)||hs.samplenumber SAMPLE,
to_char(hs.analysedtime,'hh24:mi') TIMES,ana_c.val C,ana_mn.val MN,ana_p.val P,ana_s.val S,ana_si.val SI
,ana_cu.val CU,ana_ni.val NI,ana_cr.val CR,ana_al.val AL,ana_mo.val MO,ana_sn.val SN
,ana_nb.val NB,ana_v.val V,ana_ti.val TI,ana_b.val B,ana_sb.val SB,ana_ca.val CA
,ana_as.val ASS,ana_co.val CO,ana_pb.val PB from
(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='C') ana_c
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Mn') ana_mn
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='P') ana_p
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='S') ana_s
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Si') ana_si
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Cu') ana_cu
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Ni') ana_ni
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Cr') ana_cr
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Al') ana_al
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Mo') ana_mo
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Sn') ana_sn
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Nb') ana_nb
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='V') ana_v
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Ti') ana_ti
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='B') ana_b
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Sb') ana_sb
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Ca') ana_ca
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='As') ana_as
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Co') ana_co
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Pb') ana_pb,heatsample hs,eaf1 e
where e.heatidinternal=hs.heatidinternal and ana_c.rnosample=hs.rnosample
and ana_c.rnosample=ana_mn.rnosample and ana_c.rnosample=ana_p.rnosample
and ana_c.rnosample=ana_s.rnosample and ana_c.rnosample=ana_si.rnosample
and ana_c.rnosample=ana_cu.rnosample and ana_c.rnosample=ana_ni.rnosample
and ana_c.rnosample=ana_cr.rnosample and ana_c.rnosample=ana_al.rnosample
and ana_c.rnosample=ana_mo.rnosample and ana_c.rnosample=ana_sn.rnosample
and ana_c.rnosample=ana_nb.rnosample and ana_c.rnosample=ana_v.rnosample
and ana_c.rnosample=ana_ti.rnosample and ana_c.rnosample=ana_b.rnosample
and ana_c.rnosample=ana_sb.rnosample and ana_c.rnosample=ana_ca.rnosample
and ana_c.rnosample=ana_as.rnosample and ana_c.rnosample=ana_co.rnosample
and ana_c.rnosample=ana_pb.rnosample");
    oci_execute($s);
    $cnt_row = oci_fetch_all($s, $res);
    $i=0;
    oci_execute($s);
    print("[");
    while (oci_fetch($s)) {
        $i++;
        print("{");
        print("\"sample\":\"");
        print(oci_result($s, "SAMPLE"));
        print("\",");
        print("\"times\":\"");
        print(oci_result($s, "TIMES"));
        print("\",");
        print("\"c\":\"");
        print(oci_result($s, "C"));
        print("\",");
        print("\"mn\":\"");
        print(oci_result($s, "MN"));
        print("\",");
        print("\"p\":\"");
        print(oci_result($s, "P"));
        print("\",");
        print("\"s\":\"");
        print(oci_result($s, "S"));
        print("\",");
        print("\"si\":\"");
        print(oci_result($s, "SI"));
        print("\",");
        print("\"cu\":\"");
        print(oci_result($s, "CU"));
        print("\",");
        print("\"ni\":\"");
        print(oci_result($s, "NI"));
        print("\",");
        print("\"cr\":\"");
        print(oci_result($s, "CR"));
        print("\",");
        print("\"al\":\"");
        print(oci_result($s, "AL"));
        print("\",");
        print("\"mo\":\"");
        print(oci_result($s, "MO"));
        print("\",");
        print("\"sn\":\"");
        print(oci_result($s, "SN"));
        print("\",");
        print("\"nb\":\"");
        print(oci_result($s, "NB"));
        print("\",");
        print("\"v\":\"");
        print(oci_result($s, "V"));
        print("\",");
        print("\"ti\":\"");
        print(oci_result($s, "TI"));
        print("\",");
        print("\"b\":\"");
        print(oci_result($s, "B"));
        print("\",");
        print("\"sb\":\"");
        print(oci_result($s, "SB"));
        print("\",");
        print("\"ca\":\"");
        print(oci_result($s, "CA"));
        print("\",");
        print("\"as\":\"");
        print(oci_result($s, "ASS"));
        print("\",");
        print("\"co\":\"");
        print(oci_result($s, "CO"));
        print("\",");
        print("\"pb\":\"");
        print(oci_result($s, "PB"));
        if ($cnt_row>$i) {
            print("\"},");
        }
        else {
            print("\"}");
        }
    }
    print("]");
} else {
    $err = OCIError();
}
/**
 * Created by PhpStorm.
 * User: kaa
 * Date: 15.03.2017
 * Time: 15:34
 * select (case hs.sampleplace when 1 then 'A3' when 4 then 'B3' else 'Z3' end)||hs.samplenumber SAMPLE,
to_char(hs.analysedtime,'hh24:mi') TIMES,ana_c.val C,ana_mn.val MN,ana_p.val P,ana_s.val S,ana_si.val SI
,ana_cu.val CU,ana_ni.val NI,ana_cr.val CR,ana_al.val AL,ana_mo.val MO,ana_sn.val SN
,ana_nb.val NB,ana_v.val V,ana_ti.val TI,ana_b.val B,ana_sb.val SB,ana_ca.val CA
,ana_as.val AS,ana_co.val CO,ana_pb.val PB from
(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='C') ana_c
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Mn') ana_mn
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='P') ana_p
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='S') ana_s
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Si') ana_si
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Cu') ana_cu
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Ni') ana_ni
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Cr') ana_cr
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Al') ana_al
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Mo') ana_mo
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Sn') ana_sn
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Nb') ana_nb
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='V') ana_v
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Ti') ana_ti
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='B') ana_b
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Sb') ana_sb
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Ca') ana_ca
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='As') ana_as
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Co') ana_co
,(select to_char(ha.value,'0.000') VAL,hs.rnosample rnosample from heatsample hs,
heatanalysis ha, displayorder do where hs.rnosample=ha.rnosample
and ha.element=do.element and ha.element='Pb') ana_pb,heatsample hs,heat e
where e.heatidinternal=hs.heatidinternal and ana_c.rnosample=hs.rnosample
and ana_c.rnosample=ana_mn.rnosample and ana_c.rnosample=ana_p.rnosample
and ana_c.rnosample=ana_s.rnosample and ana_c.rnosample=ana_si.rnosample
and ana_c.rnosample=ana_cu.rnosample and ana_c.rnosample=ana_ni.rnosample
and ana_c.rnosample=ana_cr.rnosample and ana_c.rnosample=ana_al.rnosample
and ana_c.rnosample=ana_mo.rnosample and ana_c.rnosample=ana_sn.rnosample
and ana_c.rnosample=ana_nb.rnosample and ana_c.rnosample=ana_v.rnosample
and ana_c.rnosample=ana_ti.rnosample and ana_c.rnosample=ana_b.rnosample
and ana_c.rnosample=ana_sb.rnosample and ana_c.rnosample=ana_ca.rnosample
and ana_c.rnosample=ana_as.rnosample and ana_c.rnosample=ana_co.rnosample
and ana_c.rnosample=ana_pb.rnosample and e.heatid=365456
 */