# Kør script
# PowerShell -ExecutionPolicy Bypass -File .\create_page.ps1

# Eksempel .\create_page.ps1 hero >> hero.php

# Det her script løser problemet med at skulle oprette en side på en mere konsistent måde.
# Løser ikke autoomatisk tilføjelse af header (pille). Men problemet løses ved hjælp af javascript _b_header.js

# Opretter 6 filer
# 1 php fil
# 3 html filer
# 1 css og js fil
#
# Eksempel .\create_page.ps1 hero >> hero.php
#
# hero.php
# head-hero.html, main-hero.html, foot-hero.html
# js/hero.js
# hero.css

# put alle sider i en mappe
# steengede.com/hero




[CmdletBinding()]
param (
    [Parameter()]
    [string]
    $pagename,
    [Parameter()]
    [string]
    $overwriteAll,
    [Parameter()]
    [string]
    $overwritePHP,
    [Parameter()]
    [string]
    $overwriteHTML,
    [Parameter()]
    [string]
    $overwriteCSS,
    [Parameter()]
    [string]
    $overwriteJS
)



# Pagename variabler
$contentFolderName = $pagename
$index = "index.php"
$javascript = "script.js"
$style = "style.css"


# // ----- head ----- //
#   // head-start.html indenholder default v?rdier
#   // head-hero.html hero content
#   // head-end.html  
# // ----- head ----- //
# // ----- body -----//
#     // header.html
#     // hero.html
#     // footer.html
# // ----- body -----//
# // ----- foot ----- //
#   // foot-start.html
#   // foot-hero.html
#   // foot-end.html
# // ----- foot ----- //

# // denne variable er navnet pa php filen.
# // $fileNameOfThisFile="hero3";

# Powershell variabler
$locationRelativToThisScript = "./public"


# // fil lokationer
$gLocation = "../global/html";
$lLocation = ".";

# // alle fil navn i variabler
# // ----- head ----- //
  $gHeadStart = "head-start.html";
  $lHead = "head.html";
  $gHeadEnd = "head-end.html";
# // ----- head ----- //
#     // ----- body -----//
#       // ----- header ----- //
        $gHeader = "header.html";
      # // ----- header ----- //

      # // ----- hero (pagename) ----- //
        $lMain = "main.html";
      # // ----- hero (pagename) ----- //

      # // ----- footer ----- //
        $gFooter = "footer.html";
#       // ----- footer ----- //
#     // ----- body -----//
# // ----- foot ----- //
  $gFootStart = "foot-start.html";
  $lFoot = "foot.html";
  $gFoodEnd = "foot-end.html";
# // ----- foot ----- //




# # put alle sider i en mappe 
# if (-not ($overwriteAll -eq $true)) {

#   # sikrer at filerne ikke findes i forvejen. Ny tilføjelse fra github

#   # ----- PHP ----- #
#   if ((Test-Path -Path ".\$pagename.php") -and (-not $overwritePHP -eq $true)) 
#   { 
#     Write-Warning "Filen: .\$pagename.php findes allerede."
#     Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwritePHP `$true' eller '-overwriteAll `$true'"
#     exit 1
#   }
#   # ----- PHP ----- #

#   # ----- HTML ----- #
#   if ((Test-Path -Path ".\_ab_head-$pagename.html") -and (-not $overwriteHTML -eq $true)) {
#     Write-Warning "Filen: .\_ab_head-$pagename.html findes allerede."
#     Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteHTML `$true' eller '-overwriteAll `$true'"
#     exit 1
#   }

#   if ((Test-Path -Path ".\_c_main-$pagename.html") -and (-not $overwriteHTML -eq $true)) {
#     Write-Warning "Filen: .\_c_main-$pagename.html findes allerede."
#     Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteHTML `$true' eller '-overwriteAll `$true'"
#     exit 1
#   }

#   if ((Test-Path -Path ".\_eb_foot-$pagename.html") -and (-not $overwriteHTML -eq $true)) {
#     Write-Warning "Filen: .\_eb_foot-$pagename.html findes allerede."
#     Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteHTML `$true' eller '-overwriteAll `$true'"
#     exit 1
#   }
#   # ----- HTML ----- #

#   # ----- CSS ----- #
#   if ((Test-Path -Path ".\css\_c_main-$pagename.css") -and (-not $overwriteCSS -eq $true)) {
#     Write-Warning "Filen: .\css\_c_main-$pagename.css findes allerede."
#     Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteCSS `$true' eller '-overwriteAll `$true'"
#     exit 1
#   }
#   # ----- CSS ----- #

#   # ----- JS ----- #
#   if ((Test-Path -Path ".\js\_c_main-$pagename.js") -and (-not $overwriteJS -eq $true)) {
#     Write-Warning "Filen: .\js\_c_main-$pagename.js findes allerede."
#     Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteJS `$true' eller '-overwriteAll `$true'"
#     exit 1
#   }
#   # ----- JS ----- #
# }



# Laver komponenter

# ----- Folder ----- #
bash -c "mkdir $locationRelativToThisScript/$lLocation/$contentFolderName"
# ----- Folder ----- #


# ----- PHP ----- #

Write-Host 
"<?php

// php scriptet echo'er en fil struktur som gør at du har en konsistent header og footer i pa din side


// ----- head ----- //
  // head-start.html indenholder default værdier
  // head-hero.html hero content
  // head-end.html  
// ----- head ----- //
// ----- body -----//
    // header.html
    // hero.html
    // footer.html
// ----- body -----//
// ----- foot ----- //
  // foot-start.html
  // foot-hero.html
  // foot-end.html
// ----- foot ----- //

// denne variable er navnet pa php filen.
// `$fileNameOfThisFile=`"$pagename`";

// fil lokationer
`$gLocation = `"../global/html`";
`$lLocation = `".`";

// alle fil navn i variabler
// ----- head ----- //
  `$gHeadStart = `"head-start.html`";
  `$lHead = `"head.html`";
  `$gHeadEnd = `"head-end.html`";
// ----- head ----- //
    // ----- body -----//
      // ----- header ----- //
        `$gHeader = `"header.html`";
      // ----- header ----- //

      // ----- hero (pagename) ----- //
        `$lMain = `"main.html`";
      // ----- hero (pagename) ----- //

      // ----- footer ----- //
        `$gFooter = `"footer.html`";
      // ----- footer ----- //
    // ----- body -----//
// ----- foot ----- //
  `$gFootStart = `"foot-start.html`";
  `$lFoot = `"foot.html`";
  `$gFoodEnd = `"foot-end.html`";
// ----- foot ----- //

// ------ Denne del echo'er hele html siden ------ //
  // ----- head ----- //
    // head-start
    `$tabs=`"`";
    `$contentLocation=`"`$gLocation/`$gHeadStart`";
    echo `"`$tabs<!-- `$contentLocation -->\n`";
    echo file_get_contents(`"`$contentLocation`");
    echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";

    // head
    `$tabs=`"\t`";
    `$contentLocation=`"`$lLocation/`$lHead`";
    echo `"`$tabs<!-- `$contentLocation -->\n`";
    echo file_get_contents(`"`$contentLocation`");
    echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";

    // head-end
    `$tabs=`"`";
    `$contentLocation=`"`$gLocation/`$gHeadEnd`";
    echo `"`$tabs<!-- `$contentLocation -->\n`";
    echo file_get_contents(`"`$contentLocation`");
    echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";
  // ----- head ----- //

    // ----- body -----//

      // ----- header ----- //
      // header
        `$tabs=`"\t`";
        `$contentLocation=`"`$gLocation/`$gHeader`";
        echo `"`$tabs<!-- `$contentLocation -->\n`";
        echo file_get_contents(`"`$contentLocation`");
        echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";
      // ----- header ----- //

      // ----- main ----- //
      // hero
        `$tabs=`"\t`";
        `$contentLocation=`"`$lLocation/`$lMain`";
        echo `"`$tabs<!-- `$contentLocation -->\n`";
        echo file_get_contents(`"`$contentLocation`");
        echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";
      // ----- main ----- //

      // ----- footer ----- //
      // footer
        `$tabs=`"\t`";
        `$contentLocation=`"`$gLocation/`$gFooter`";
        echo `"`$tabs<!-- `$contentLocation -->\n`";
        echo file_get_contents(`"`$contentLocation`");
        echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";
      // ----- footer ----- //
    // ----- body -----//

  // ----- foot ----- //
    // foot-start
    `$tabs=`"`";
    `$contentLocation=`"`$gLocation/`$gFootStart`";
    echo `"`$tabs<!-- `$contentLocation -->\n`";
    echo file_get_contents(`"`$contentLocation`");
    echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";

    // foot
    `$tabs=`"`";
    `$contentLocation=`"`$lLocation/`$lFoot`";
    echo `"`$tabs<!-- `$contentLocation -->\n`";
    echo file_get_contents(`"`$contentLocation`");
    echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";

    // foot-end
    `$tabs=`"`";
    `$contentLocation=`"`$gLocation/`$gFoodEnd`";
    echo `"`$tabs<!-- `$contentLocation -->\n`";
    echo file_get_contents(`"`$contentLocation`");
    echo `"\n`$tabs<!-- `$contentLocation -->\n\n\n\n`";
  // ----- foot ----- //
// ------ Denne del echo'er hele html siden ------ //" `
  | Out-File -Encoding ascii -FilePath "$locationRelativToThisScript\$contentFolderName\$index" -NoNewline
# ----- PHP ----- #



# ----- HTML ----- #
$thisPageElementName = "head.html"

Write-Host
  "    <title>$pagename</title>
    <link rel='preconnect' href='https://fonts.gstatic.com'>
    <link href='https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;1,100&display=swap' rel='stylesheet'>
    <link href='./$pagename.css' rel='stylesheet'/>" `
  | Out-File -Encoding ascii -FilePath "$locationRelativToThisScript\$contentFolderName\$thisPageElementName" -NoNewline


$thisPageElementName = "main.html"
Write-Host
"    <main id='main'>      
        <h1>Hello World!</h1>
    </main>" `
  | Out-File -Encoding ascii -FilePath "$locationRelativToThisScript\$contentFolderName\$thisPageElementName" -NoNewline 


$thisPageElementName = "foot.html"
Write-Host
"<script src='./$pagename.js'></script>" `
  | Out-File -Encoding ascii -FilePath "$locationRelativToThisScript\$contentFolderName\$thisPageElementName" -NoNewline


# ----- HTML ----- #

# ----- CSS ----- #
$thisPageElementName = "style.css"
Write-Host
"body {
  
}" | Out-File -Encoding ascii -FilePath "$locationRelativToThisScript\$contentFolderName\$thisPageElementName" -NoNewline

# ----- CSS ----- #

# ----- JS ----- #
$thisPageElementName  = "script.js"
Write-Host
"console.log('Hello World from $pagename.js')" `
  | Out-File -Encoding ascii -FilePath "$locationRelativToThisScript\$contentFolderName\$thisPageElementName" -NoNewline
  # bash -c "chown www-data:www-data ./$contentFolderName/$thisPageElementName && chmod 655 ./$contentFolderName/$thisPageElementName"
# ----- JS ----- #

# Korrigere rettigheder for den nye lokale mappe
bash -c "chown www-data:www-data -R $locationRelativToThisScript/$lLocation/$contentFolderName"
bash -c "chmod 750 -R $locationRelativToThisScript/$lLocation/$contentFolderName"

# Overskriver rettigheder for den globale mappe
bash -c "chown www-data:www-data -R $locationRelativToThisScript/global"
bash -c "chmod 750 -R $locationRelativToThisScript/global"