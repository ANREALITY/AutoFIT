<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Base\Annotation\Export;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ServiceInvoicePositionPersonal
 *
 * @ORM\Table(name="ServiceInvoicePositionPersonal")
 * @ORM\Entity
 */
class ServiceInvoicePositionPersonal extends AbstractServiceInvoicePosition
{

    /**
     * @param ArticlePersonal $article
     *
     * @return AbstractServiceInvoicePosition
     */
    public function setArticle(ArticlePersonal $article = null)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return ArticlePersonal
     */
    public function getArticle()
    {
        return $this->article;
    }

}
