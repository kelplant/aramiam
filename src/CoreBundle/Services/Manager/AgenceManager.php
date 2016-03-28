<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Agence;

/**
 * Class AgenceManager
 * @package CoreBundle\Manager
 */
class AgenceManager extends BaseManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    protected $entity;

    protected $entityName;

    /**
     * AgencesManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->entity = Agence::class;
        $this->entityName = 'Agence';
    }

    /**
     * @param Agence $agence
     */
    public function save(Agence $agence)
    {
        $this->persistAndFlush($agence);
    }

    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return mixed
     */
    public function globalSetItem($itemToSet,$itemLoad)
    {
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setNameInCompany($itemLoad['nameInCompany']);
        $itemToSet->setNameInOdigo($itemLoad['nameInOdigo']);
        $itemToSet->setNameInSalesforce($itemLoad['nameInSalesforce']);
        $itemToSet->setNameInZendesk($itemLoad['nameInZendesk']);

        return $itemToSet;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CoreBundle:'.$this->entityName);
    }

    /**
     * @param $itemId
     * @return null|object
     */
    public function load($itemId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $itemId));
    }

    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function add($itemLoad)
    {
        $itemToSet = new $this->entity;
        $itemToSet = $this->globalSetItem($itemToSet,$itemLoad);

        try {
            $this->save($itemToSet);
            return $message = 6669;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @return bool|int
     */
    public function remove($itemId)
    {
        $items = $this->getRepository()->findById($itemId);
        try {
            foreach ($items as $item) {
                $this->em->remove($item);
                $this->em->flush();
            }
            return $message = 6668;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @param $itemLoad
     * @return bool|string
     */
    public function edit($itemId, $itemLoad)
    {
        try
        {
            $itemToSet = $this->getRepository()->findOneById($itemId);
            $this->globalSetItem($itemToSet,$itemLoad);
            $this->em->flush();
            return $message = "6667";
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function createList()
    {
        $datas = $this->getRepository()->findAll();
        $finalDatas = [];
        foreach ($datas as $data) {
            $finalDatas[$data->getName()] = $data->getId();
        }
        return $finalDatas;
    }
}