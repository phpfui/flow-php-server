<?php
namespace Flow;

class Uploader {

    /**
     * Delete chunks older than expiration time.
     * @param string $chunksFolder
     * @param int $expirationTime seconds
     * @throws Exception
     */
    public static function pruneChunks($chunksFolder, $expirationTime = 172800)
    {
        $handle = opendir($chunksFolder);
        if (!$handle) {
            throw new Exception('Failed to open folder');
        }
        while (false !== ($entry = readdir($handle))) {
            if ($entry == "." || $entry == "..") {
                continue;
            }
            $path = $chunksFolder . DIRECTORY_SEPARATOR . $entry;
            if (is_dir($path)) {
                continue;
            }
            if (time() - filemtime($path) > $expirationTime) {
                unlink($path);
            }
        }
        closedir($handle);
    }
}