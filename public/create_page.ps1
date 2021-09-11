# Kør script
# PowerShell -ExecutionPolicy Bypass -File .\create_page.ps1

# Det her script løser problemet med at skulle oprette en side på en mere konsistent måde.
# Løser ikke autoomatisk tilføjelse af header (pille)

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

# 
if (-not ($overwriteAll -eq $true)) {

  # sikrer at filerne ikke findes i forvejen.

  # ----- PHP ----- #
  if ((Test-Path -Path ".\$pagename.php") -and (-not $overwritePHP -eq $true)) 
  { 
    Write-Warning "Filen: .\$pagename.php findes allerede."
    Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwritePHP `$true' eller '-overwriteAll `$true'"
    exit 1
  }
  # ----- PHP ----- #

  # ----- HTML ----- #
  if ((Test-Path -Path ".\_ab_head-$pagename.html") -and (-not $overwriteHTML -eq $true)) {
    Write-Warning "Filen: .\_ab_head-$pagename.html findes allerede."
    Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteHTML `$true' eller '-overwriteAll `$true'"
    exit 1
  }

  if ((Test-Path -Path ".\_c_main-$pagename.html") -and (-not $overwriteHTML -eq $true)) {
    Write-Warning "Filen: .\_c_main-$pagename.html findes allerede."
    Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteHTML `$true' eller '-overwriteAll `$true'"
    exit 1
  }

  if ((Test-Path -Path ".\_eb_foot-$pagename.html") -and (-not $overwriteHTML -eq $true)) {
    Write-Warning "Filen: .\_eb_foot-$pagename.html findes allerede."
    Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteHTML `$true' eller '-overwriteAll `$true'"
    exit 1
  }
  # ----- HTML ----- #

  # ----- CSS ----- #
  if ((Test-Path -Path ".\css\_c_main-$pagename.css") -and (-not $overwriteCSS -eq $true)) {
    Write-Warning "Filen: .\css\_c_main-$pagename.css findes allerede."
    Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteCSS `$true' eller '-overwriteAll `$true'"
    exit 1
  }
  # ----- CSS ----- #

  # ----- JS ----- #
  if ((Test-Path -Path ".\js\_c_main-$pagename.js") -and (-not $overwriteJS -eq $true)) {
    Write-Warning "Filen: .\js\_c_main-$pagename.js findes allerede."
    Write-Warning "Hvis du vil overskrive filen sa tilfoj '-overwriteJS `$true' eller '-overwriteAll `$true'"
    exit 1
  }
  # ----- JS ----- #
}



# Laver komponenter

# ----- PHP ----- #
Write-Host
"<?php

// denne variable er navnet på php filen.
`$page=`"$pagename`";


// ----- head ----- //
// head (<head>)
`$tabs=`"`";
`$filename=`"./_aa_head-start.html`";
echo `"`$tabs<!-- `$filename -->\n`";
echo file_get_contents(`"`$filename`");
echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";

// head-default
`$tabs=`"\t`";
`$filename=`"./_ab__head-default.html`";
echo `"`$tabs<!-- `$filename -->\n`";
echo file_get_contents(`"`$filename`");
echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";

// head-<page>
`$tabs=`"\t`";
`$filename=`"./_ab_head-`$page.html`";
echo `"`$tabs<!-- `$filename -->\n`";
echo file_get_contents(`"`$filename`");
echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";

// head-end
`$tabs=`"`";
`$filename=`"./_ac_head-end.html`";
echo `"`$tabs<!-- `$filename -->\n`";
echo file_get_contents(`"`$filename`");
echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";
// ----- head ----- //

  // ----- body -----//
    // ----- header ----- //
    `$tabs=`"\t`";
    `$filename=`"./_ba_header.html`";
    echo `"`$tabs<!-- `$filename -->\n`";
    echo file_get_contents(`"`$filename`");
    echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";
    // ----- header ----- //

    // ----- main ----- //
    `$tabs=`"\t`";
    `$filename=`"./_c_main-`$page.html`";
    echo `"`$tabs<!-- `$filename -->\n`";
    echo file_get_contents(`"`$filename`");
    echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";
    // ----- main ----- //

    // ----- footer ----- //
    `$tabs=`"\t`";
    `$filename=`"./_d_footer.html`";
    echo `"`$tabs<!-- `$filename -->\n`";
    echo file_get_contents(`"`$filename`");
    echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";
    // ----- footer ----- //
  // ----- body -----//

// foot
`$tabs=`"`";
`$filename=`"./_ea_foot-start.html`";
echo `"`$tabs<!-- `$filename -->\n`";
echo file_get_contents(`"`$filename`");
echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";

// foot-<page>
`$tabs=`"`";
`$filename=`"./_eb_foot-`$page.html`";
echo `"`$tabs<!-- `$filename test -->\n`";
echo file_get_contents(`"`$filename`");
echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";

// foot-end
`$tabs=`"`";
`$filename=`"./_ec_foot-end.html`";
echo `"`$tabs<!-- `$filename -->\n`";
echo file_get_contents(`"`$filename`");
echo `"\n`$tabs<!-- `$filename -->\n\n\n\n`";" `
| Out-File -Encoding ascii -FilePath ".\$pagename.php" -NoNewline
# ----- PHP ----- #



# ----- HTML ----- #
Write-Host
"  <title>$pagename</title>
  <link rel='preconnect' href='https://fonts.gstatic.com'>
  <link href='https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;1,100&display=swap' rel='stylesheet'>
  <link href='./css/_c_main-$pagename.css' rel='stylesheet'/>" `
| Out-File -Encoding ascii -FilePath ".\_ab_head-$pagename.html" -NoNewline


Write-Host
"  <main id='main'>      

  </main>" `
| Out-File -Encoding ascii -FilePath ".\_c_main-$pagename.html" -NoNewline 

Write-Host
"<script src='./js/_c_main-$pagename.js'></script>" `
| Out-File -Encoding ascii -FilePath ".\_eb_foot-$pagename.html" -NoNewline

# ----- HTML ----- #

# ----- CSS ----- #
Write-Host
"body {
  
}" | Out-File -Encoding ascii -FilePath ".\css\_c_main-$pagename.css" -NoNewline
# ----- CSS ----- #

# ----- JS ----- #
Write-Host
"console.log('Hello World from _c_main-$pagename.js')" | Out-File -Encoding ascii -FilePath ".\js\_c_main-$pagename.js" -NoNewline
# ----- JS ----- #