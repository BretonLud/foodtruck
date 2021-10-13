import React from 'react';
import Modal from './Modal';
import useModal from './useModal';



 
export default function Product(props) {
    const {onAdd, menuItem} = props
    const {isShowing, toggle, isProduct} = useModal();

    return (
            <div className="row space-between">
                <Modal onAdd={onAdd} product={isProduct} isShowing={isShowing} hide={toggle}/>

                    {
                        menuItem.map((product) => {       
                        return <div key={product.name}className="product">
                            <img onClick={(e) => toggle(product)} className="small" src={product.image} alt={product.name}></img>
                            <h3>{product.name}</h3>
                            <div>€{product.price}</div>
                            <div>
                                <button className="btn btn-product" onClick={() => onAdd(product)}>Add To Cart</button>
                            </div>
                        </div> 
                        })
                    }
            </div>
    )
}
