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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);
        $statusCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode < 200 || $statusCode >= 300) {
            try {
                return json_encode(
                    [
                        'statusCode' => $statusCode,
                        'error' => json_decode($data, true, 512, JSON_THROW_ON_ERROR)
                    ],
                    JSON_THROW_ON_ERROR
                );
            } catch (JsonException $e) {
                $this->modx->log(\xPDO::LOG_LEVEL_ERROR, 'noembed error: ' . $e->getMessage());
                return '';
            }
        }

        if (empty($data)) {
            return '[]';
        }

        return $data;
    }
}
