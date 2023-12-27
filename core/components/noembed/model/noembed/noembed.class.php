<?php
/**
 * Created by PhpStorm.
 * User: mat
 * Date: 5/29/2018
 * Time: 10:28
 */

class noembed
{

    public $config = array();
    private modX $modx;

    public function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;
        $corePath = $this->modx->getOption('noembed.core_path', $config, $this->modx->getOption('core_path') . 'components/noembed/');
        $this->config = array_merge(array(
            'basePath' => $this->modx->getOption('base_path'),
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'snippetPatth' => $corePath . 'elements/snippets/',
        ), $config);
        $this->modx->addPackage('noembed', $this->config['modelPath']);
    }

    public function getResponse($link)
    {
        if (empty($link)) {
            return [];
        }

        $url = 'https://noembed.com/embed?nowrap=on&url=' . urlencode($link);

        $result = $this->fileGetContentsCurl($url);
        
        return $this->modx->fromJSON($result);
    }

    public function fileGetContentsCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
