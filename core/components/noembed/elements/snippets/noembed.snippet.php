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
if (!($noembed instanceof noembed))
    return;

$response = $return = [];
$link = $modx->getOption('link', $scriptProperties, null);
$tpl = $modx->getOption('tpl', $scriptProperties, $options);

if(!empty($input)){
   $response = $noembed->getResponse($input);
}

if(!empty($link)){
    $response = $noembed->getResponse($link);
}

if(!empty($tpl)){
    $return =  $modx->getChunk($tpl, $response);
}else{
    $return = !empty($response['html']) ? $response['html'] : $response['url'];
}

return $return;
