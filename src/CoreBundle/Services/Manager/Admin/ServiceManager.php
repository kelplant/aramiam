<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\Service;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Doctrine\Common\Util\Inflector;

/**
 * Class ServiceManager
 * @package CoreBundle\Services\Manager
 */
class ServiceManager extends AbstractManager
{

    /**
     * @param $entity
     */
    protected function persistAndFlush($entity)
    {
        $parent = $this->getRepository()->findOneById($entity->getParentService());
        $entity->setParent($parent);
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param $itemToEditId
     * @param $ContentToAddToEditedItem
     * @return array
     */
    public function edit($itemToEditId, $ContentToAddToEditedItem) {
        try {
            $itemToSet = $this->globalSetItem($this->getRepository()->findOneById($itemToEditId), $ContentToAddToEditedItem);
            $itemToSet->setUpdatedAt(new \DateTime());
            $parent = $this->getRepository()->findOneById($itemToSet->getParentService());
            $itemToSet->setParent($parent);
            $this->em->flush();
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Mis(e) à jour'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }

        return array('item' => $itemToEditId);
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad) {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['id']                    = $itemToTransform->getId();
        $itemArray['name']                  = $itemToTransform->getName();
        $itemArray['shortName']             = $itemToTransform->getShortName();
        $itemArray['nameInCompany']         = $itemToTransform->getNameInCompany();
        $itemArray['nameInOdigo']           = $itemToTransform->getNameInOdigo();
        $itemArray['nameInSalesforce']      = $itemToTransform->getNameInSalesforce();
        $itemArray['nameInZendesk']         = $itemToTransform->getNameInZendesk();
        $itemArray['parentAgence']          = $itemToTransform->getParentAgence();
        $itemArray['parentService']         = $itemToTransform->getParentService();
        $itemArray['parent']                = $itemToTransform->getParent();
        $itemArray['nameInActiveDirectory'] = $itemToTransform->getNameInActiveDirectory();

        return $itemArray;
    }

    /**
     * @return array
     */
    public function getStandardServiceListe()
    {
        $finalTab = [];

        foreach ($this->getRepository()->findBy(array(), array('name' => 'ASC')) as $enreg) {
            $finalTab[] = array('id' => $enreg->getId(), 'name' => $enreg->getName());
        }
        return $finalTab;
    }

    /**
     * @param $nameInOdigo
     * @return mixed
     */
    public function returnIdFromOdigoName($nameInOdigo)
    {
        return $this->getRepository()->findOneByNameInOdigo($nameInOdigo)->getId();
    }

    /**
     *
     */
    public function customSelectNameInActiveDirectoryNotNull() {

        $queryResult = $this->em->createQuery(
            'SELECT p.nameInActiveDirectory
    FROM CoreBundle:Admin\Service p
    WHERE p.nameInActiveDirectory IS NOT NULL')->getResult();
        $finalTab = [];
        foreach ($queryResult as $result) {
            $finalTab[] = $result['nameInActiveDirectory'];
        }
        return $finalTab;
    }

    private function getHighestLvl()
    {
        return $this->getRepository()
            ->createQueryBuilder('e')
            ->select('MAX(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param $serviceId
     * @param $lvl
     * @param $options
     * @return mixed
     */
    public function generateTree($serviceId, $lvl, $options)
    {
        if ($lvl == null) {
            $lvl = $this->getHighestLvl();
        }

        $query = $this->getRepository()
            ->createQueryBuilder('b')
            ->select('b', 'a')
            ->from('CoreBundle:Admin\Service', 'a')
            ->where('a.id = :id')
            ->andWhere('b.root = 1')
            ->andWhere('b.lft >= a.lft')
            ->andWhere('b.rgt <= a.rgt')
            ->andWhere('a.lvl + :lvladd >= b.lvl')
            ->orderBy('b.lft', 'ASC')
            ->setParameter(':id', $serviceId)
            ->setParameter(':lvladd', $lvl)
            ->getQuery()->getArrayResult();
        unset($query[0]);

        return $this->getRepository()->buildTree($query, $options);
    }
}