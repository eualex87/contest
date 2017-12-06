<?php
namespace SiteBundle\Service;


use Doctrine\ORM\EntityManager;
use SiteBundle\Entity\Detalii;
use SiteBundle\Entity\Imagini;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterService
{
    /** @var  EntityManager $entityManager*/
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $results
     */
    public function saveRegister($results, $imageId = null)
    {
        /** @var Detalii $details */
        $details = new Detalii();
        $details->setNume($results['required_last_name'])
            ->setPrenume($results['required_first_name'])
            ->setDn(new \DateTime($results['date']))
            ->setGen($results['required_sex']=='m'?'1':'2')
            ->setEmail($results['required_email'])
            ->setAnonim(array_key_exists('anonymous',$results)?'1':'0')
            ->setAdaugat(new \DateTime(date('d-m-Y')))
            ->setModificat(new \DateTime(date('d-m-Y H:i:s')))
            ->setAprobaImagine('-1')
            ->setAprobaMesaj('-1')
            ->setIdImg($imageId)
            ->setPremiu('-1');
        if ($results['message']) {
            $details->setMesaj($results['message']);
        }

        return $this->entityManager->persist($details);
    }

    /**
     * @param $name
     * @param $folder
     * @param $hash
     */
    public function saveImage($name, $folder, $hash)
    {
        /** @var Imagini $image */
        $image = new Imagini();
        $image->setNume($name)
            ->setAdaugat(new \DateTime(date('d-m-Y H:m:i')))
            ->setFolder($folder)
            ->setHash($hash);
        $this->entityManager->persist($image);
        $this->entityManager->flush();
        return $image->getId();
    }
}