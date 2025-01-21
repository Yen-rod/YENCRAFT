<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?float $precio = null;

    #[ORM\Column(length: 255)]
    private ?string $imagen = null;

    #[ORM\ManyToOne(targetEntity: Categoria::class)]
    #[ORM\JoinColumn(nullable: false)]  //JoinColum para evitar que se permita un producto sin categoría.
    private ?Categoria $categoria = null;
    

    //#[ORM\ManyToMany(targetEntity: Pedido::class, mappedBy: 'productos')]
    //private Collection $pedidos;

    #[ORM\OneToMany(mappedBy: 'producto', targetEntity: PedidoProducto::class)]
    private Collection $pedidoProductos;

    public function __construct()
    {
        //$this->pedidos = new ArrayCollection();
        $this->pedidoProductos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    //public function getPedidos(): Collection
   // {
    //    return $this->pedidos;
    //}

    //public function addPedido(Pedido $pedido): static
    //{
   //     if (!$this->pedidos->contains($pedido)) {
    //        $this->pedidos->add($pedido);
    //        $pedido->addProducto($this);
     //   }

    //    return $this;
    //}

    //public function removePedido(Pedido $pedido): static
    //{
     //   if ($this->pedidos->removeElement($pedido)) {
     //       $pedido->removeProducto($this);
     //   }

    //    return $this;
   // }

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
            $pedidoProducto->setProducto($this);
        }

        return $this;
    }

    public function removePedidoProducto(PedidoProducto $pedidoProducto): self
    {
        if ($this->pedidoProductos->removeElement($pedidoProducto)) {
            // Set the owning side to null (unless already changed)
            if ($pedidoProducto->getProducto() === $this) {
                $pedidoProducto->setProducto(null);
            }
        }

        return $this;
    }


    public function __toString(): string
    {
    return $this->nombre ?? 'Producto sin nombre';
    }
}
