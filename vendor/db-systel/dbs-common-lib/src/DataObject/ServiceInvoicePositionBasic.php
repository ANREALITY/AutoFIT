<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use DbSystel\Annotation\Export;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ServiceInvoicePositionBasic
 *
 * @ORM\Table(name="ServiceInvoicePositionBasic")
 * @ORM\Entity
 */
class ServiceInvoicePositionBasic extends AbstractServiceInvoicePosition
{

    /**
     * @param ArticleBasic $article
     *
     * @return AbstractServiceInvoicePosition
     */
    public function setArticle(ArticleBasic $article = null)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return ArticleBasic
     */
    public function getArticle()
    {
        return $this->article;
    }

}
