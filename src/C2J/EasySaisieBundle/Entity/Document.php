<?php

namespace C2J\EasySaisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="C2J\EasySaisieBundle\Entity\DocumentRepository")
 */
class Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
	
	public $file;
	
	public $promotion;

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/documents';
    }
	
	public function upload()
	{
		if (null === $this->file) {
			return;
		}

		$this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

		$this->path = $this->file->getClientOriginalName();

		$this->file = null;
	}
	
	/**
   * Set promotion
   *
   * @param \C2J\EasySaisieBundle\Entity\Promotion $promotion
   * @return Document
   */
  public function setPromotion(\C2J\EasySaisieBundle\Entity\Promotion $promotion = null)
  {
      $this->promotion = $promotion;
  
      return $this;
  }

  /**
   * Get promotion
   *
   * @return \C2J\EasySaisieBundle\Entity\Promotion 
   */
  public function getPromotion()
  {
      return $this->promotion;
  }
}
