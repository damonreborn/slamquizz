<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 * @ORM\Table(name="tbl_answer")
 */
class Answer
{
    /**
     * @var int The id of this Answer
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string The text of this Answer
     * @ORM\Column(type="string", length=255)
     */
    private $Text;

    /**
     * @var boolean The Correction of this Answer
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Correct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    public function getCorrect(): ?bool
    {
        return $this->Correct;
    }

    public function setCorrect(bool $Correct): self
    {
        $this->Correct = $Correct;

        return $this;
    }
}
