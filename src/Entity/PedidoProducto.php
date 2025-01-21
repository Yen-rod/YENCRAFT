<?php

namespace App\Entity;

use App\Repository\PedidoProductoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoProductoRepository::class)]
class PedidoProducto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Pedido::class, inversedBy: 'pedidoProductos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pedido $pedido = null;

    #[ORM\ManyToOne(targetEntity: Producto::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producto $producto = null;

    #[ORM\Column]
    private int $cantidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }
}
