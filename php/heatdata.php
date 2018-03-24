<?php
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "SELECT nvl(to_char(h.heatid),'-') HEATID,nvl(to_char(h.heatstart,'dd.mm.yyyy hh24:mi:ss'),'-') HEATSTART,nvl(to_char(s.longtext),'-') STATUS,
nvl(to_char(e.TOTALPOWER),'-') TOTALPOWER,nvl(to_char(h.analysisidact),'-') MARKA,nvl(to_char(h.meltingprofile),'-') MELTINGPROFILE, nvl(round(h.hotheelprevious/1000,1),0) HOTHEELPREVIOUS,
nvl(round(h.hotheelplan/1000,1),0) HOTHEELPLAN, ht.ladleid LADLEID,ht.heatsonladle HEATSONLADLE,ss.ladletemp LADLETEMP, scr.wght SCRAP,buck.buckets BUCKETS,
nvl(to_char(h.CREWID),'-') PROFILEMORE,nvl(to_char(round(e.CURRCALCBATHTEMP,1)),'-') TEMP,nvl(to_char(l1m.ELEPOWACT),'-') DSPON, h.taptempplan TAPTEMPPLAN, round(h.tapweightplan/1000,1) TAPWEIGHTPLAN,
nvl(to_char(l1m.STIRARCONS),'-') ARGON, nvl(to_char(l1m.STIRN2CONS),'-') AZOT, nvl(round(e.timetilltap/60),0) TILLTAP, nvl(durh.durheat,0) DURHEAT, durd.durdel DURDEL,
case when (nvl(l1m.drifdact,0)<0.5) then 0 else round(nvl(l1m.drifdact,0),2) end as DRIFDACT, nvl(l1m.drispecfdsetp,0) DRISPECFDSETP, round(nvl(l1m.drifdcons,0)/1000,1) DRIFDCONS,
round(nvl(l1m.drifdtotwt,0)/1000,2) DRIFDTOTWT,case when (nvl(l1m.limfdact,0)<0.5) then 0 else round(nvl(l1m.limfdact,0),2) end as LIMFDACT, nvl(l1m.limfdsetp,0) LIMFDSETP,
nvl(l1m.limfdcons,0) LIMFDCONS, nvl(l1m.limfdtotwt,0) LIMFDTOTWT,nvl(e.remactentilltap,0) REMACTENTILLTAP,round(nvl(e.specactelen,0)*1000,2) SPECACTELEN,
nvl(e.specremenght,0) SPECREMENGHT,round(nvl(e.actlosses,0),2) ACTLOSSES,round(nvl(l1m.elepowact,0),2) ELEPOWACT,round(nvl(l1m.elepowreact,0),2) ELEPOWREACT,
round(nvl(e.powerfactor,0),2) POWERFACTOR,nvl(l1m.elevoltapact,0) ELEVOLTAPACT, nvl(l1m.mltotwt,0) MLTOTWT,nvl(l1m.stiraract,0) AR_RASHOD,nvl(l1m.stirn2act,0) N2_RASHOD,
nvl(l1m.stirarcons,0) AR_KOL,nvl(l1m.stirn2cons,0) N2_KOL, round(nvl(e.currmetbathwght,0)/1000,2) CURRMETBATHWGHT, temp_r.TEMP_ZAMER TEMP_ZAMER
FROM heat h, eaf1 e, status s, level1mmi l1m, heattapping ht,(select nvl(round((sysdate-min(hp.eventtime))*1440),0) durheat,h.heatid from heatpoweron hp, heat h
where hp.heatidinternal=h.heatidinternal group by h.heatid) durh, (select d.heat_name, nvl(round(sum((d.end_time-d.start_time)*1440)),0) durdel from heatdelay d group by d.heat_name) durd,
stirringstand ss,(select nvl(round(sum(weightact)/1000,1),0) wght, e.heatid heat from bucketmaterial bm, bucket b, eaf1 e
where e.rnoheatorder=b.rnoheatorder and b.rnobucmat=bm.rnobucmat group by e.heatid) scr,
(select b1||'  '||b2||'  '||b3||'  '||b4 buckets, buc1.heatid heat from (select b1.bucketno b1, e.heatid heatid
from bucket b1,eaf1 e where e.rnoheatorder=b1.rnoheatorder and b1.bucketsequence=1) buc1,
(select b2.bucketno b2, e.heatid heatid from bucket b2,eaf1 e where e.rnoheatorder=b2.rnoheatorder
and b2.bucketsequence=2) buc2, (select b3.bucketno b3, e.heatid heatid from bucket b3,eaf1 e
where e.rnoheatorder=b3.rnoheatorder and b3.bucketsequence=3) buc3, (select b4.bucketno b4, e.heatid heatid
from bucket b4,eaf1 e where e.rnoheatorder=b4.rnoheatorder and b4.bucketsequence=4) buc4
where buc1.heatid=buc2.heatid(+) and buc1.heatid=buc3.heatid(+) and buc1.heatid=buc4.heatid(+)) buck,
(SELECT HEATIDINTERNAL,MEASUREDTEMP TEMP_ZAMER FROM HEATMEASUREMENT WHERE MEASUREDTIME = (SELECT MAX(MEASUREDTIME) FROM HEATMEASUREMENT
WHERE (MEASUREMENTTYPE = 'EM' OR MEASUREMENTTYPE = 'DM'))) temp_r
WHERE h.heatidinternal=e.heatidinternal and h.heatstatus=s.statusno and h.heatid=durh.heatid(+) and h.heatid=durd.heat_name(+) and h.heatidinternal=ht.heatidinternal(+)
and h.heatidinternal=ss.heatidinternal(+) and e.heatid=scr.heat(+) and e.heatid=buck.heat(+) and h.heatidinternal=temp_r.heatidinternal(+)");
    oci_execute($s);
    while (oci_fetch($s)) {
        print("{");
        print("\"heatid\":\"");
        print(oci_result($s, "HEATID"));
        print("\",");
        print("\"heatstart\":\"");
        print(oci_result($s, "HEATSTART"));
        print("\",");
        print("\"statusi\":\"");
        print(oci_result($s, "STATUS"));
        print("\",");
        print("\"totalpower\":\"");
        print(oci_result($s, "TOTALPOWER"));
        print("\",");
        print("\"marka\":\"");
        print(oci_result($s, "MARKA"));
        print("\",");
        print("\"meltingprofile\":\"");
        print(oci_result($s, "MELTINGPROFILE"));
        print("\",");
        print("\"profilemore\":\"");
        print(oci_result($s, "PROFILEMORE"));
        print("\",");
        print("\"temp\":\"");
        print(oci_result($s, "TEMP"));
        print("\",");
        print("\"dspon\":\"");
        print(oci_result($s, "DSPON"));
        print("\",");
        print("\"argon\":\"");
        print(oci_result($s, "ARGON"));
        print("\",");
        print("\"tilltap\":\"");
        print(oci_result($s, "TILLTAP"));
        print("\",");
        print("\"durheat\":\"");
        print(oci_result($s, "DURHEAT"));
        print("\",");
        print("\"durdel\":\"");
        print(oci_result($s, "DURDEL"));
        print("\",");
        print("\"taptempplan\":\"");
        print(oci_result($s, "TAPTEMPPLAN"));
        print("\",");
        print("\"tapweightplan\":\"");
        print(oci_result($s, "TAPWEIGHTPLAN"));
        print("\",");
        print("\"hotheelprevious\":\"");
        print(oci_result($s, "HOTHEELPREVIOUS"));
        print("\",");
        print("\"hotheelplan\":\"");
        print(oci_result($s, "HOTHEELPLAN"));
        print("\",");
        print("\"ladleid\":\"");
        print(oci_result($s, "LADLEID"));
        print("\",");
        print("\"heatsonladle\":\"");
        print(oci_result($s, "HEATSONLADLE"));
        print("\",");
        print("\"ladletemp\":\"");
        print(oci_result($s, "LADLETEMP"));
        print("\",");
        print("\"scrap\":\"");
        print(oci_result($s, "SCRAP"));
        print("\",");
        print("\"buckets\":\"");
        print(oci_result($s, "BUCKETS"));
        print("\",");
        print("\"drifdact\":\"");
        print(oci_result($s, "DRIFDACT"));
        print("\",");
        print("\"drispecfdsetp\":\"");
        print(oci_result($s, "DRISPECFDSETP"));
        print("\",");
        print("\"drifdcons\":\"");
        print(oci_result($s, "DRIFDCONS"));
        print("\",");
        print("\"drifdtotwt\":\"");
        print(oci_result($s, "DRIFDTOTWT"));
        print("\",");
        print("\"limfdact\":\"");
        print(oci_result($s, "LIMFDACT"));
        print("\",");
        print("\"limfdsetp\":\"");
        print(oci_result($s, "LIMFDSETP"));
        print("\",");
        print("\"limfdcons\":\"");
        print(oci_result($s, "LIMFDCONS"));
        print("\",");
        print("\"limfdtotwt\":\"");
        print(oci_result($s, "LIMFDTOTWT"));
        print("\",");
        print("\"remactentilltap\":\"");
        print(oci_result($s, "REMACTENTILLTAP"));
        print("\",");
        print("\"specactelen\":\"");
        print(oci_result($s, "SPECACTELEN"));
        print("\",");
        print("\"specremenght\":\"");
        print(oci_result($s, "SPECREMENGHT"));
        print("\",");
        print("\"actlosses\":\"");
        print(oci_result($s, "ACTLOSSES"));
        print("\",");
        print("\"elepowact\":\"");
        print(oci_result($s, "ELEPOWACT"));
        print("\",");
        print("\"elepowreact\":\"");
        print(oci_result($s, "ELEPOWREACT"));
        print("\",");
        print("\"powerfactor\":\"");
        print(oci_result($s, "POWERFACTOR"));
        print("\",");
        print("\"elevoltapact\":\"");
        print(oci_result($s, "ELEVOLTAPACT"));
        print("\",");
        print("\"mltotwt\":\"");
        print(oci_result($s, "MLTOTWT"));
        print("\",");
        print("\"stiraract\":\"");
        print(oci_result($s, "AR_RASHOD"));
        print("\",");
        print("\"stirn2act\":\"");
        print(oci_result($s, "N2_RASHOD"));
        print("\",");
        print("\"stirarcons\":\"");
        print(oci_result($s, "AR_KOL"));
        print("\",");
        print("\"stirn2cons\":\"");
        print(oci_result($s, "N2_KOL"));
        print("\",");
        print("\"currmetbathwght\":\"");
        print(oci_result($s, "CURRMETBATHWGHT"));
        print("\",");
        print("\"temp_zamer\":\"");
        print(oci_result($s, "TEMP_ZAMER"));
        print("\",");
        print("\"azot\":\"");
        print(oci_result($s, "AZOT"));
        print("\"}");
    }
} else {
    $err = OCIError(); //
}
?>