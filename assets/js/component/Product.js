import React from 'react';
import Modal from './Modal';
import useModal from './useModal';



 
export default function Product(props) {
    const {onAdd, menuItem} = props
    const {isShowing, toggle, isProduct} = useModal();
    

    return (
            <div className="row">
                <Modal onAdd={onAdd} product={isProduct} isShowing={isShowing} hide={toggle}/>

                    {
                        menuItem.map((product) => {  
                            {if (product.stock == true) { 
                        return <div key={product.name}className="product">
                            <img onClick={(e) => toggle(product)} className="small" src={product.image} alt={product.name}></img>
                            <h3>{product.name}</h3>
                            <div>{product.price} €</div>
                            <div>
                                {loggedIn ? <button className="btn btn-product" onClick={() => onAdd(product)}>Ajouter au panier</button> : "" }
                            </div>
                        </div> 
                            }}
                        })
                    }
            </div>
    )
}
