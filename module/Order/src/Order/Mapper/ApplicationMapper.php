<?php
namespace Order\Mapper;

use DbSystel\DataObject\Application;

class ApplicationMapper extends AbstractMapper implements ApplicationMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = Application::class;

    /**
     * @return Application[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('a')->from(static::ENTITY_TYPE, 'a');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('technical_short_name', $condition)) {
                    $queryBuilder
                        ->andWhere('a.technicalShortName LIKE :technicalShortName')
                        ->setParameter('technicalShortName', '%' . $condition['technical_short_name'] . '%')
                    ;
                }
                if (array_key_exists('active', $condition)) {
                    $queryBuilder
                        ->andWhere('a.active = :active')
                        ->setParameter('active', $condition['active'])
                    ;
                }
                // Lagacy (not ORM driven) part. Not migrated to Doctrine, since not used for now.
                // Related to the question: "What is a valid InvoicePosition/Appliacation?"
//                if (array_key_exists('with_invoice_positions_only', $condition) && $condition['with_invoice_positions_only'] === true) {
//                    $select->join('service_invoice', 'service_invoice.application_technical_short_name = application.technical_short_name');
//                    $select->join(['service_invoice_position_basic' => 'service_invoice_position'], new Expression('service_invoice_position_basic.service_invoice_number = service_invoice.number AND service_invoice_position_basic.order_quantity > 0 AND service_invoice_position_basic.status <> "Beendet"'));
//                    $select->join(['article_basic' => 'article'], new Expression('service_invoice_position_basic.article_sku = article_basic.sku AND article_basic.type = "basic"'));
//                    // If this condition is used sometime again, complete it with product_type_name=cd|fgw for basic.
//                    $select->join(['service_invoice_position_personal' => 'service_invoice_position'], new Expression('service_invoice_position_personal.service_invoice_number = service_invoice.number AND service_invoice_position_personal.order_quantity > 0 AND service_invoice_position_personal.status <> "Beendet"'));
//                    $select->join(['article_personal' => 'article'], new Expression('service_invoice_position_personal.article_sku = article_personal.sku AND article_personal.type = "personal"'));
//                    // If this condition is used sometime again, complete it with product_type_name=cd|fgw for personal.
//                }
            }
        }

        $queryBuilder->setMaxResults($limit ?: null);

        $query = $queryBuilder->getQuery();
        $result = $query->execute(null, $hydrationMode);

        return $result;
    }

}
