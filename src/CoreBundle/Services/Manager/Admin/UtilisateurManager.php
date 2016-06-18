<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\Utilisateur;
use DateTime;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class UtilisateurManager
 * @package CoreBundle\Services\Manager
 */
class UtilisateurManager extends AbstractManager
{
    private $nbMajPassword;

    /**
     * @param $partOfPass
     * @param $what
     * @param $maxrand
     * @return string
     */
    private function randomPasswordTestforCap($partOfPass, $what, $maxrand)
    {
        $conso = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z');
        $majconso = array('B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z');
        $vocal = array('a', 'e', 'i', 'u');
        $majvocal = array('A', 'E', 'I', 'U');
        if (rand(0, 1) == 0 && $this->nbMajPassword < 2) {
            $what = 'maj'.$what;
            $partOfPass .= ${$what}[rand(0, $maxrand)];
            $this->nbMajPassword = $this->nbMajPassword + 1;
        } else {
            $partOfPass .= ${$what}[rand(0, $maxrand)];
        }
        return $partOfPass;
    }

    /**
     * @param $len
     * @return string
     */
    private function randomPassword($len) {

        srand((double)microtime() * 1000000);
        $max = ($len - 2) / 2;
        $password = [];
        $password[0] = rand(1, 9);
        $password[1] = rand(1, 9);
        $this->nbMajPassword = 0;
        for ($i = 1; $i <= $max; $i++) {
            $partOfPass = '';
            $partOfPass = $this->randomPasswordTestforCap($partOfPass, 'conso', '19');
            $partOfPass = $this->randomPasswordTestforCap($partOfPass, 'vocal', '3');
            $password[$i + 1] = $partOfPass;
        }
        shuffle($password);
        $newPassword = '';
        foreach ($password as $passPart) {
            $newPassword .= $passPart;
        }
        return $newPassword;
    }


    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function transform($itemLoad)
    {
        $itemLoad['idCandidat']           = $itemLoad['id'];
        $itemLoad['isCreateInGmail']      = null;
        $itemLoad['isCreateInOdigo']      = null;
        $itemLoad['isCreateInRobusto']    = null;
        $itemLoad['isCreateInSalesforce'] = null;
        $itemLoad['isCreateInWindows']    = null;
        $itemLoad['viewName']             = $itemLoad['surname']." ".$itemLoad['name'];
        $itemLoad['email']                = null;
        $itemLoad['mainPassword']         = $this->randomPassword(8);

        $itemToSet = new Utilisateur();

        try {
            $this->save($this->globalSetItem($itemToSet, $itemLoad));
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' '.$itemLoad['surname']." ".$itemLoad['name'].' a eté correctionement Transformé'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $item
     * @param $i
     * @param $lastIfExist
     * @param $possibleItems
     * @return array
     */
    private function recursiveListe($item, $i, $lastIfExist, $possibleItems)
    {
        $items = explode(' ', str_replace('-', ' ', strtolower($item)));

        if ($i == 0) {
            $possibleItems[] = $newItem = $items[0];
            return $this->recursiveListe($item, $i + 1, $newItem, $possibleItems);
        } else {
            while ($i < count($items)) {
                $newItem = $lastIfExist;
                $possibleItems[] = $newItem.'-'.$items[$i];
                return $this->recursiveListe($item, $i + 1, $newItem.'-'.$items[$i], $possibleItems);
            }
            return $possibleItems;
        }
    }

    /**
     * @param $utilisateurId
     * @return array
     */
    public function generateListPossibleEmail($utilisateurId)
    {
        $itemToTransform = $this->getRepository()->findOneById($utilisateurId);
        $possibleEmails = [];

        $possibleSurnames = $this->recursiveListe($itemToTransform->getSurname(), 0, null, array());
        $possibleNames = $this->recursiveListe($itemToTransform->getName(), 0, null, array());
        foreach ($possibleSurnames as $surname) {
            foreach ($possibleNames as $name) {
                $possibleEmails[] = $surname.'.'.$name.'@aramisauto.com';
            }
        }
        return $possibleEmails;
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform                   = $this->getRepository()->findOneById($itemLoad);
        $itemArray                         = [];
        $itemArray['id']                   = $itemToTransform->getId();
        $itemArray['name']                 = $itemToTransform->getName();
        $itemArray['surname']              = $itemToTransform->getSurname();
        $itemArray['viewName']             = $itemToTransform->getViewName();
        $itemArray['civilite']             = $itemToTransform->getCivilite();
        $itemArray['startDate']            = $itemToTransform->getStartDate()->format('d-m-Y');
        $itemArray['entiteHolding']        = $itemToTransform->getEntiteHolding();
        $itemArray['email']                = $itemToTransform->getEmail();
        $itemArray['mainPassword']         = $itemToTransform->getMainPassword();
        $itemArray['agence']               = $itemToTransform->getAgence();
        $itemArray['service']              = $itemToTransform->getService();
        $itemArray['fonction']             = $itemToTransform->getFonction();
        $itemArray['statusPoste']          = $itemToTransform->getStatusPoste();
        $itemArray['predecesseur']         = $itemToTransform->getPredecesseur();
        $itemArray['responsable']          = $itemToTransform->getResponsable();
        $itemArray['matriculeRH']          = $itemToTransform->getMatriculeRH();
        $itemArray['commentaire']          = $itemToTransform->getCommentaire();
        $itemArray['isArchived']           = $itemToTransform->getIsArchived();
        $itemArray['idCandidat']           = $itemToTransform->getIdCandidat();
        $itemArray['isCreateInGmail']      = $itemToTransform->getIsCreateInGmail();
        $itemArray['isCreateInOdigo']      = $itemToTransform->getIsCreateInOdigo();
        $itemArray['isCreateInRobusto']    = $itemToTransform->getIsCreateInRobusto();
        $itemArray['isCreateInSalesforce'] = $itemToTransform->getIsCreateInSalesforce();
        $itemArray['isCreateInWindows']    = $itemToTransform->getIsCreateInWindows();
        return $itemArray;
    }

    /**
     * @param Utilisateur $itemToSet
     * @param $itemLoad
     * @return mixed
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setCivilite($itemLoad['civilite']);
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setSurname($itemLoad['surname']);
        $itemToSet->setViewName($itemLoad['viewName']);
        $itemToSet->setStartDate(new DateTime($itemLoad['startDate']));
        $itemToSet->setAgence($itemLoad['agence']);
        $itemToSet->setEmail($itemLoad['email']);
        $itemToSet->setMainPassword($itemLoad['mainPassword']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setMatriculeRH($itemLoad['matriculeRH']);
        $itemToSet->setEntiteHolding($itemLoad['entiteHolding']);
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setResponsable($itemLoad['responsable']);
        $itemToSet->setStatusPoste($itemLoad['statusPoste']);
        $itemToSet->setPredecesseur($itemLoad['predecesseur']);
        $itemToSet->setCommentaire($itemLoad['commentaire']);
        $itemToSet->setIsArchived('0');
        $itemToSet->setIdCandidat($itemLoad['idCandidat']);
        $itemToSet->setIsCreateInGmail($itemLoad['isCreateInGmail']);
        $itemToSet->setIsCreateInOdigo($itemLoad['isCreateInOdigo']);
        $itemToSet->setIsCreateInRobusto($itemLoad['isCreateInRobusto']);
        $itemToSet->setIsCreateInSalesforce($itemLoad['isCreateInSalesforce']);
        $itemToSet->setIsCreateInWindows($itemLoad['isCreateInWindows']);
        return $itemToSet;
    }

    /**
     * @param $itemToSet
     * @param $emailToSet
     */
    public function setEmail($itemToSet, $emailToSet)
    {
        $itemToSet = $this->getRepository()->findOneById($itemToSet);
        $itemToSet->setEmail($emailToSet);
        $itemToSet->setIsCreateInGmail('1');
        $this->em->flush();

        return $emailToSet;
    }

    /**
     * @param $itemToSet
     * @param $prosodieNumId
     * @return mixed
     */
    public function setIsCreateInOdigo($itemToSet, $prosodieNumId)
    {
        $itemToSet = $this->getRepository()->findOneById($itemToSet);
        $itemToSet->setIsCreateInOdigo($prosodieNumId);
        $this->em->flush();

        return $prosodieNumId;
    }

    /**
     * @param $itemToSet
     * @param $guid
     * @return mixed
     */
    public function setIsCreateInWindows($itemToSet, $guid)
    {
        $item = $this->getRepository()->findOneById($itemToSet);
        $item->setIsCreateInWindows($guid);
        $this->em->flush();

        return $itemToSet;
    }

    /**
     * @param $isArchived
     * @return mixed
     */
    public function getlist($isArchived)
    {
        $sql = "SELECT a.id, a.is_archived as isArchived, a.name, a.surname, a.start_date as startDate, b.agence_name as agence, c.service_name as service, d.fonction_name as fonction FROM aramiam.core_admin_utilisateurs a LEFT JOIN aramiam.core_admin_agences b ON b.id = a.agence  LEFT JOIN aramiam.core_admin_services c ON c.id = a.service LEFT JOIN aramiam.core_admin_fonctions d ON d.id = a.fonction WHERE a.is_archived =".$isArchived;

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @return array
     */
    public function createListForSelect()
    {
        $sql        = "SELECT a.id, a.view_name, a.name FROM aramiam.core_admin_utilisateurs a WHERE a.is_archived = 0 AND a.view_name IS NOT NULL AND a.name IS NOT NULL AND a.surname IS NOT NULL ORDER BY a.view_name";
        $stmt       = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $datas      = $stmt->fetchAll();
        $finalDatas = [];
        foreach ($datas as $data) {
                $finalDatas[$data['view_name']] = $data['id'];
        }
        return $finalDatas;
    }
}