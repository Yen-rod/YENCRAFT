<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'pedidos')]
    private ?Usuario $usuario = null;

    //#[ORM\ManyToMany(targetEntity: Producto::class, inversedBy: 'pedidos', cascade:['persist'])]
    //private Collection $productos;

    #[ORM\OneToMany(mappedBy: 'pedido', targetEntity: PedidoProducto::class, cascade: ['persist'])]
    private Collection $pedidoProductos;

    public function __construct()
    {
        //$this->productos = new ArrayCollection();
        $this->pedidoProductos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection<int, Producto>
     */
    //public function getProductos(): Collection
    //{
    //    return $this->productos;
    //}

   //public function addProducto(Producto $producto): static
    //{
     //   if (!$this->productos->contains($producto)) {
     //       $this->productos->add($producto);
     //   }

     //   return $this;
    //}

    //public function removeProducto(Producto $producto): static
    //{
     //   $this->productos->removeElement($producto);

     //   return $this;
    //}

////////////////////////////
        /**
     * @return Collection<int, PedidoProducto>
     */
    public function getPedidoProductos(): Collection
    {
        return $this->pedidoProductos;
    }

    public function addPedidoProducto(PedidoProducto $pedidoProducto): self
    {
        if (!$this->pedidoProductos->contains($pedidoProducto)) {
            $this->pedidoProductos[] = $pedidoProducto;
            $pedidoProducto->setPedido($this);
        }

        return $this;
    }

    public function removePedidoProducto(PedidoProducto $pedidoProducto): self
    {
        if ($this->pedidoProductos->removeElement($pedidoProducto)) {
            // Set the owning side to null (unless already changed)
            if ($pedidoProducto->getPedido() === $this) {
                $pedidoProducto->setPedido(null);
            }
        }

        return $this;
    }

}
