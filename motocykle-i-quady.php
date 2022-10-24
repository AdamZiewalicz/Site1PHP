<html>
<head><title>Otomoto</title><style>
table {

  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style></head>
<body>
<?php
ini_set('user_agent', 'My-Application/2.5');

$SearchResult=file_get_contents("https://www.otomoto.pl/motocykle-i-quady");		//wciskamy do stringa cały kod


?>
<h1 align="center"><a href="loggedinhomepage.php">Go back to homepage</a></h1><br/> 
<form method="POST">
<label for="pages">How many pages do you want to access?</label><br/>
<input type="number" id="pages" name="pages">
<input type="Submit" value="submit">
</form>
<?php
/*$howManyPages=['pages'];*/
if(isset($_POST['pages'])){
$howManyPages=$_POST['pages'];
echo "Showing links for ".$howManyPages." pages <br/>";
$howManyPages++;

$link=array();
$name=array();																		//deklarujemy link jako tablice
$LinkSearchLike=urlencode("https://www.otomoto.pl/oferta/"); 									//deklarujemy wzor
									    //dlugosc wzoru 
$LinkSearchLike=urldecode($LinkSearchLike);											//no fucking clue why this is necessary but i guess it is????
$linksearchlikelength=strlen($LinkSearchLike);

for($counter=2;$counter<=$howManyPages;$counter++)
{$currentPageFirstLink="none";
for($i=0; $i<strlen($SearchResult);$i++) 											//przechodzimy kazdy znak (i) na obecnej stronie
{	
if($SearchResult[$i]=="h")															//jesli trafimy na h 
  {
if(substr($SearchResult,$i,5)=="https") 											//jesli trafimy na https
	{ 						//to znalezlismy poczatek jakiegos linku 
																			
			
		if(substr($SearchResult,$i,$linksearchlikelength)==$LinkSearchLike) 		//jesli trafimy na nasz wzór
		{
		
		for($z=$i;$z<strlen($SearchResult);$z++) 											//szukamy dla zmiennej z
			{
			if($SearchResult[$z]=="h") 												//gdzie jest następny h i html 
				{if(substr($SearchResult,$z,4)=="html")
					{$positionEndingLink=$z+5;   												//oznaczamy to jako "position ending link"
					 	$positionStartingName=$positionEndingLink+1;							//znajdujemy position starting name 
					 	
break;						
					}
			
				}																//łamiemy pętlę
			}
			$linklength=$positionEndingLink-$i;								//dalej jest ustalone position ending link i position starting name 		
/*echo substr($SearchResult,$i+8,$linklength-9)."<br/>";		*/					//dlugosc naszego wypisu wtedy jest oznaczona jako linklength
if(substr($SearchResult,$i+8,$linklength-9)==$currentPageFirstLink){break;}
 if($currentPageFirstLink=="none"){$currentPageFirstLink=substr($SearchResult,$i+8,$linklength-9);} //pod tym jest wszystko co sie dzieje co link bez duplikatu
	$nameidx=$positionStartingName;
					 while($SearchResult[$nameidx]!="<")
						{$nameidx++;
						}	$nameidx--;
					$namelength=$nameidx-$positionStartingName;
					$namelength++;
	$name[]=substr($SearchResult,$positionStartingName,$namelength);

	 $link[]=substr($SearchResult,$i+8,$linklength-9);
	 $i+=$linklength-9;
		}
		
																					//link array się dokłada.
																					//przerzucamy się od razu do nastepnego znaku po linku
	}
  }
}
$SearchResult=file_get_contents("https://www.otomoto.pl/motocykle-i-quady?page=".$counter);
}
?>
<table align="center">
<tr>
<th>Names</th></tr>
<?php
for($i=0;$i<count($link);$i++)
{

	echo "<tr><td><a href=https://".$link[$i].">".$name[$i]."</a></td></tr>";
}}
?>

</table>
</body>
</html>