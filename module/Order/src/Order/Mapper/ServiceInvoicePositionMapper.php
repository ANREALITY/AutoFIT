<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractArticle;
use DbSystel\DataObject\ArticleBasic;
use DbSystel\DataObject\ArticleOnDemand;
use DbSystel\DataObject\ArticlePersonal;
use DbSystel\DataObject\ServiceInvoicePosition;

class ServiceInvoicePositionMapper extends AbstractMapper implements ServiceInvoicePositionMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = ServiceInvoicePosition::class;

    /**
     * @inheritdoc
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('sip')->from(static::ENTITY_TYPE, 'sip');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('number', $condition)) {
                    $queryBuilder
                        ->andWhere('sip.number LIKE :number')
                        ->setParameter('number', '%' . $condition['number'] . '%')
                    ;
                }
            }
            if (is_array($condition)) {
                if (array_key_exists('active', $condition)) {
                    $queryBuilder
                        ->andWhere('sip.status <> :status')
                        ->setParameter('status', ServiceInvoicePosition::STATUS_COMPLETED)
                    ;
                }
            }
            if (
                array_key_exists('article_type', $condition)
                || array_key_exists('product_type_name', $condition)
            ) {
                $queryBuilder->join('sip.article', 'ar');
                if (array_key_exists('article_type', $condition)) {
                    $typeToClassMap = [
                        AbstractArticle::TYPE_BASIC => ArticleBasic::class,
                        AbstractArticle::TYPE_PERSONAL => ArticlePersonal::class,
                        AbstractArticle::TYPE_ON_DEMAND => ArticleOnDemand::class,
                    ];
                    $queryBuilder
                        ->andWhere($queryBuilder->expr()->isInstanceOf(
                            'ar',
                            $typeToClassMap[$condition['article_type']]
                        ))
                    ;
                }
                if (array_key_exists('product_type_name', $condition)) {
                    $queryBuilder
                        ->andWhere('ar.productType = :productTypeName')
                        ->setParameter('productTypeName', $condition['product_type_name'])
                    ;
                }
            }
            if (is_array($condition)) {
                if (array_key_exists('available', $condition)) {
                    $queryBuilder
                        ->andWhere('sip.orderQuantity > :orderQuantity')
                        ->setParameter('orderQuantity', 0)
                    ;
                }
            }
            if (
                array_key_exists('application_technical_short_name', $condition)
                || array_key_exists('environment_severity', $condition)
            ) {
                $queryBuilder->join('sip.serviceInvoice', 'si');
                if (array_key_exists('application_technical_short_name', $condition)) {
                    $queryBuilder->join('si.application', 'a');
                    $queryBuilder
                        ->andWhere('a.technicalShortName = :technicalShortName')
                        ->setParameter('technicalShortName', $condition['application_technical_short_name'])
                    ;
                    $queryBuilder->distinct();
                }
                if (array_key_exists('environment_severity', $condition)) {
                    $queryBuilder->join('si.environment', 'e');
                    $queryBuilder
                        ->andWhere('e.severity = :environmentSeverity')
                        ->setParameter('environmentSeverity', $condition['environment_severity'])
                    ;
                    $queryBuilder->distinct();
                }
            }
        }

        $queryBuilder->setMaxResults($limit ?: null);

        $query = $queryBuilder->getQuery();
        $result = $query->execute(null, $hydrationMode);

        return $result;
    }

}
