<?  $DocFileInc='../customRules.inc.php';   $DocVers='1.3.1';  $DocRev='2023-09-02';  $DocIni='evs';  $ModulNo=0; ## File informative only

  ## In php2html.lib.php this file is included: 
  ##    if (is_readable('customRules.inc.php')) include('customRules.inc.php');  
   # Here you can add your special rules 

    // if (false)
    if ($list==['','']) $rowType= '';
    else {
        $Drow= $DataRow;
        if ((isset($list[0]) ? $list[0] : '') == 'KONTOPLAN') {
          
          $rowType= strtoupper($Drow[3]);
          switch ($rowType) {  //  Kontotype: D=Drift, S=Status, Z=Sum, H=Overskrift, R=Resultat, X=Sideskift, L=Lukket',
          case 'H': { $rowBg= RowBg('lightyellow','bottom','top');
                      $bgColor= '';                                                          
                      $Drow[3]= ' '; $Drow[5]= ' '; $Drow[6]=' '; $Drow[7]=' '; $Drow[8]=' '; $Drow[9]=' '; $Drow[10]=' '; 
                      // $Drow[2]= '<span style="font-weight: 600; font-size: smaller; text-align:left;">'.$Drow[2].'</span>';
                      if ($bdy[2]!='hidd') $bdy[2]= 'html';
                      $ixalign= 'text-align:center; '; 
                      $captStyle= 'font-weight:600;';
                    }; break;                                                                
          case 'D':   $Drow[3] = lang('@Drift');   $rowBg= ''; $ixalign= 'text-align:right;'; $captStyle= ''; break;                        
          case 'S':   $Drow[3] = lang('@Status');  $rowBg= ''; $ixalign= 'text-align:right;'; $captStyle= ''; break;                        
          case 'T': { $rowBg= RowBg('lightgreen','top');
                      $bgColor= '';  $Drow[9]=' '; 
                      if ($Drow[7]=='') { $Drow[7]='0'; $rowBg.= ' border-top:2px solid gray;'; }
                      $Drow[3] = lang('@Total fra:'); //  $row[fra_kto] - $row[til_kto]
                      $ixalign= 'text-align:center;'; 
                      $captStyle= '';
                    }; break;
          case 'Z': { $rowBg= RowBg('lightcyan','top');
                      $bgColor= '';  $Drow[9]=' '; 
                      if ($Drow[7]=='') { $Drow[7]='0'; $rowBg.= ' border-top:2px solid gray;'; }
                      $Drow[3] = lang('@Sum fra:'); //  $row[fra_kto] - $row[til_kto]
                      $ixalign= 'text-align:center;'; 
                      $captStyle= '';
                    }; break;
          case 'R': { $rowBg= RowBg('lightgreen','center');
                      $bgColor= '';
                      $Drow[2] = lang('@Årets resultat'); // The result of the year
                      $Drow[3]= ' ';  $Drow[5]= ' ';  $Drow[8]=' '; $Drow[9]=' '; 
                      // $Drow[3] = lang('@Sum fra:'); 
                      $ixalign= 'text-align:center;'; 
                      $captStyle= '';
                    }; break;
          case 'X':   // $Drow[1]='';  //  lang('@Sideskift'); Page break 
                      $Drow[2]=' '; $Drow[3]=lang('@Sideskift'); $Drow[5]= ' '; $Drow[6]=' '; $Drow[7]=' '; $Drow[8]=' '; $Drow[9]=' ';  $Drow[10]=' '; 
                      $rowBg= ' background:darkgray; '; 
                      // ? 'indx' _> 
                      $bdy[1]= 'hidd';  // background: transparent;
                      break;
            }
        }
        $DataRow= $Drow;
    }
?>