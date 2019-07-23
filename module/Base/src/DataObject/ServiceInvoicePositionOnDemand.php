<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Base\Annotation\Export;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ServiceInvoicePositionOnDemand
 *
 * @ORM\Table(name="ServiceInvoicePositionOnDemand")
 * @ORM\Entity
 */
class ServiceInvoicePositionOnDemand extends AbstractServiceInvoicePosition
{

    /**
     * @param ArticleOnDemand $article
     *
     * @return AbstractServiceInvoicePosition
     */
    public function setArticle(ArticleOnDemand $article = null)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return ArticleOnDemand
     */
    public function getArticle()
    {
        return $this->article;
    }

}
