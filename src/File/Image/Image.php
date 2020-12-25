<?php
/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "CVS: cvs_id"
 * @link     Link
 */

namespace App\File\Image;

use App\File\File;
use Intervention\Image\ImageManager;

/**
 * Gère les fichiers image.
 * 
 * @category Category
 * @package  App\backend
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "Release: package_version"
 * @link     Link
 */
class Image extends File
{
    /**
     * Tableau contenant les extensions de fichiers de type image
     * autorisées.
     * 
     * @var array
     */
    const VALID_EXTENSIONS = ["png", "jpg", "jpeg", "gif"];

    /**
     * Taille maximale des fichiers de types images autorisée.
     * 
     * @var int
     */
    const MAX_VALID_SIZE = 2097152;

    /**
     * Extension des images.
     * 
     * @var string
     */
    const EXTENSION = ".jpg";

    /**
     * Chemin du dossier contenant les images.
     * 
     * @var string
     */
    const IMG_DIR_PATH = ASSETS_DIR_PATH . "img" . DIRECTORY_SEPARATOR;
    const IMG_DIR_URL = ASSETS_DIR_URL . "/img";

    /**
     * Chemin et url du dossier contenant les images des slides.
     * 
     * @var string
     */
    const SLIDERS_DIR_PATH = self::IMG_DIR_PATH . "slider" . DIRECTORY_SEPARATOR;
    const SLIDERS_DIR_URL = self::IMG_DIR_URL . "/slider";

    /**
     * La thumbs par défaut des éléments.
     * 
     * @var string
     */
    const DEFAULT_THUMBS = self::IMG_DIR_URL . "/default-thumbs" . self::EXTENSION;

    const PRODUCT_DIR_PATH = self::IMG_DIR_PATH . "product" . DIRECTORY_SEPARATOR;
    const PRODUCT_DIR_URL = self::IMG_DIR_URL . "/product";

    const FEATURED_DIR_PATH = self::IMG_DIR_PATH . "featured" . DIRECTORY_SEPARATOR;
    const FEATURED_DIR_URL = self::IMG_DIR_URL . "/featured";

    const PRODUCT_INFO_DIR_PATH = self::IMG_DIR_PATH . "productinfo" . DIRECTORY_SEPARATOR;
    const PRODUCT_INFO_DIR_URL = self::IMG_DIR_URL . "/productinfo";

    /**
     * Permet de sauvegarder l'image dans les fichiers du serveur dans le dossier des
     * images et des miniatures.
     * 
     * @param string $imageName Le nom de l'image.
     * @param string $width
     * @param string $height
     * 
     * @return bool
     */
    public static function saveImages(string $imageName, int $width = 1280, int $height = 720)
    {
        // self::save($imageName, self::THUMBS_PATH, $width, $height);
        // self::save($imageName, self::ORIGINALS_THUMBS_PATH);
        return true;
    }

    /**
     * Créer une miniature et la sauvegarde.
     * 
     * @param $avatarName Le nom du fichier
     * 
     * @return void
     */
    public static function saveAvatar($avatarName)
    {
        self::save($avatarName, Avatar::AVATARS_DIR_PATH, 150, 150);
        return true;
    }

    /**
     * Enregistre une image en prenant en paramètre le nom et le dossier de
     * sauvegarde.
     * 
     * @param string $imageName 
     * @param string $dirPath     Le dossier où on doit déposer l'image.
     * @param int    $imageWidth 
     * @param int    $imageHeight 
     * 
     * @return bool
     */
    public static function save(string $baseFilePath, string $imageName, string $dirPath, int $imageWidth = null, int $imageHeight = null)
    {
        if (!file_exists($dirPath)) {
            mkdir($dirPath);
        }

        $manager = new ImageManager();
        $manager = $manager->make($baseFilePath);

        if (null !== $imageWidth && null !== $imageHeight){
            $manager->fit($imageWidth, $imageHeight);
        }

        $manager->save($dirPath . $imageName . self::EXTENSION);
        return true;
    }

    /**
     * Renomme l'image de couverture et l'image miniature d'un item.
     * 
     * @param string $oldName L'ancien nom de l'image.
     * @param string $newName Le nouveau nom de l'image.
     * 
     * @return bool
     */
    public static function renameImages($oldName, $newName)
    {
        // $oldThumbs = self::THUMBS_PATH . $oldName;
        // $oldOriginalThumbs = self::ORIGINALS_THUMBS_PATH . $oldName;

        // $newThumbs = self::THUMBS_PATH . $newName . self::EXTENSION;
        // $newOriginalThumbs = self::ORIGINALS_THUMBS_PATH . $newName . self::EXTENSION;

        // if (rename($oldThumbs, $newThumbs) && rename($oldOriginalThumbs, $newOriginalThumbs)) {
        //     return true;
        // } else {
        //     throw new Exception("Echec du renommage de l'image de couverture.");
        // }
    }

    /**
     * Supprime les images de couverture et miniatures.
     * 
     * @param string $imageName Le nom de l'image.
     * 
     * @return bool
     */
    public static function deleteImages($imageName)
    {
        // $oldThumbsPath = self::THUMBS_PATH . $imageName;
        // if (file_exists($oldThumbsPath)) {
        //     unlink($oldThumbsPath);
        // }
        
        // $oldOrgImgPath = self::ORIGINALS_THUMBS_PATH . $imageName;
        // if (file_exists($oldOrgImgPath)) {
        //     unlink($oldOrgImgPath);
        // }
    }

}
