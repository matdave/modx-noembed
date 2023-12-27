<?php
$corePath = $modx->getOption('noembed.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/noembed/');
/** @var noembed $noembed */
$noembed = $modx->getService(
    'noembed',
    'noembed',
    $corePath . 'model/noembed/',
    array(
        'core_path' => $corePath
    )
);
if (!($noembed instanceof noembed)) {
    return;
}

$response = array();
$return = null;
$link = $modx->getOption('link', $scriptProperties, null);
$tpl = $modx->getOption('tpl', $scriptProperties, $options ?? null);

if (!empty($input)) {
    $cache = $modx->cacheManager->get(md5($input));
    if (!$cache) {
        $response = $noembed->getResponse($input);
        $modx->cacheManager->set(md5($input), $response);
    } else {
        $response = $cache;
    }
}

if (!empty($link)) {
    $cache = $modx->cacheManager->get(md5($link));
    if (!$cache) {
        $response = $noembed->getResponse($link);
        $modx->cacheManager->set(md5($link), $response);
    } else {
        $response = $cache;
    }
}

if (!empty($tpl)) {
    $return =  $modx->getChunk($tpl, $response);
} else {
    $return = !empty($response['html']) ? $response['html'] : $response['url'];
}

return $return;
