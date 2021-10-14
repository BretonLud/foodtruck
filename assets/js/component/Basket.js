import React, {useEffect, useState} from "react";
import StripeCheckout from "react-stripe-checkout";
import axios from "axios";

function handleToken(token, addresses) {
    console.log(token, addresses)
  }

    
export default function Basket(props) {
    const {cartItems, onAdd, onRemove} = props
    const itemsPrice = cartItems.reduce((a, c) => a + c.price * c.qty, 0)
    //const taxPrice = itemsPrice * 0.10
    //const shippingPrice = itemsPrice > 20 ? 0 : 3
    const totalPrice = itemsPrice// + taxPrice + shippingPrice

    const panier = JSON.stringify(cartItems, ["name", "qty", "price"])

    const submit = () => {
        axios({
          method: 'POST',
          url: '#',
          headers: {
            'Content-Type': 'application/json',
          },
          data: {
              Produits: JSON.stringify(cartItems, ["name", "qty", "price"]), 
              PrixTotal: totalPrice
          }
        })
        .then((response) => {
          console.log(response)
        })
        .catch((error) => {
          console.log(error)
        })
      }

    return <aside className="block col-1">
        <h2>Cart Items</h2>
        <div>{cartItems.length === 0 && <div>Cart is Empty</div>}</div>
        {cartItems.map((item) => (
            <form key={item.name} className="row" action="" method="post">
            <div key={item.id} className="row">
                <div className="col-2"><input type="text" name="ProductName" id="ProductName" value={item.name} readOnly={true}/></div>
                <div className="col-2">
                    <button type="button" onClick={() => onAdd(item)} className="btn add">+</button>
                    <button type="button" onClick={() => onRemove(item)} className="btn remove">-</button>
                </div>
                <div className="col-2 text-right">
                    <input type="number" name="ProductQuantity" id="ProductQuantity" value={item.qty} readOnly={true}/> x <input type="number" name="ProductPrice" id="ProductPrice" value={item.price.toFixed(2)} readOnly={true}/>€
                </div>
            </div>
            </form>
        ))}
        {cartItems.length !== 0 && (
            <>
                <hr />
                {/*<div className="row">
                    <div className="col-2">Items Price</div>
                    <div className="col-1 text-right">€{itemsPrice.toFixed(2)}</div>
                </div>
                <div className="row">
                    <div className="col-2">Tax Price</div>
                    <div className="col-1 text-right">€{taxPrice.toFixed(2)}</div>
                </div>
                <div className="row">
                    <div className="col-2">Shipping Price</div>
                    <div className="col-1 text-right">€{shippingPrice.toFixed(2)}</div>
                </div>*/}
                <div className="row">
                    <div className="col-2"><strong>Total Price</strong></div>
                    <div className="col-1 text-right"><strong>€{totalPrice.toFixed(2)}</strong></div>
                </div>
                <hr />
                <div className="row">
                <StripeCheckout 
                stripeKey="pk_test_51JjKjDCNkH9r21wgmurnRnbIkLFboSYR2wk4erBWcx6RX5TfxjnbjgJ76EdfD4U4MTHCYiX5MJTMwBtfoaq3q3p6001HiVFnNR"
                token={handleToken}
                label="Commander"
                currency="EUR"
                amount={totalPrice * 100}
                closed={submit}
                >
                    <button className="btn">Commander</button>
                </StripeCheckout>
                </div>
            </>
            
        )}
    </aside>
}