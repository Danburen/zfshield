<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = '漏洞：命令注入' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'exec';
$page[ 'help_button' ]   = 'exec';
$page[ 'source_button' ] = 'exec';

dvwaDatabaseConnect();

$vulnerabilityFile = '';
switch( dvwaSecurityLevelGet() ) {
    case 'low':
        $vulnerabilityFile = 'low.php';
        break;
    case 'medium':
        $vulnerabilityFile = 'medium.php';
        break;
    case 'high':
        $vulnerabilityFile = 'high.php';
        break;
    default:
        $vulnerabilityFile = 'impossible.php';
        break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/exec/source/{$vulnerabilityFile}";

$page[ 'body' ] .= "
<div class=\"body_padded\">
    <h1>漏洞：命令注入</h1>

    <div class=\"vulnerable_code_area\">
        <h2>Ping 设备</h2>

        <form name=\"ping\" action=\"#\" method=\"post\">
            <p>
                输入 IP 地址：
                <input type=\"text\" name=\"ip\" size=\"30\">
                <input type=\"submit\" name=\"Submit\" value=\"提交\">
            </p>\n";

if( $vulnerabilityFile == 'impossible.php' )
    $page[ 'body' ] .= "            " . tokenField();

$page[ 'body' ] .= "
        </form>
        {$html}
    </div>

    <h2>更多信息</h2>
    <ul>
        <li>" . dvwaExternalLinkUrlGet( 'https://www.scribd.com/doc/2530476/Php-Endangers-Remote-Code-Execution' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'http://www.ss64.com/bash/' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'http://www.ss64.com/nt/' ) . "</li>
        <li>" . dvwaExternalLinkUrlGet( 'https://owasp.org/www-community/attacks/Command_Injection' ) . "</li>
    </ul>
</div>\n";

dvwaHtmlEcho( $page );

?>

