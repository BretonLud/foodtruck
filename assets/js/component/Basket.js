import React, {useEffect, useState} from "react";
import StripeCheckout from "react-stripe-checkout";
import axios from "axios";




    
export default function Basket(props) {
    const {cartItems, onAdd, onRemove, loggedIn} = props
    const itemsPrice = cartItems.reduce((a, c) => a + c.price * c.qty, 0)
    //const taxPrice = itemsPrice * 0.10
    //const shippingPrice = itemsPrice > 20 ? 0 : 3
    const totalPrice = itemsPrice// + taxPrice + shippingPrice


    const panier = JSON.stringify(cartItems, ["name", "qty", "price"])

    const checkSession = () => {
        
        axios.get("http://127.0.0.1:34979/login?", {withCredentials: true}).then(response => {
            if (X = true) {
                alert("Vous êtes bien connecté")
            }
            else {
                alert("Veuillez vous connecter")
            }
        })
        .catch(error => {
            console.log("check login error")
        })
    }

    
    function handleToken(token, addresses) {
        console.log(token, addresses)
      }


    const submit = (token) => {
        axios({
          method: 'POST',
          url: '/order/',
          headers: {
            'Content-Type': 'application/json',
          },
          data: {
              Produits: JSON.stringify(cartItems, ["name", "qty", "price"]), 
              PrixTotal: totalPrice,
              StripeToken: token
          }
        })
        .then((response) => {
            alert("Commande effectuée")
            document.location.href="/order/"
        })
        .catch((error) => {
            alert("La commande n'a pu être effectué")
        })
      }

      const bouttonpaiement = <StripeCheckout 
              stripeKey="pk_test_51JjKjDCNkH9r21wgmurnRnbIkLFboSYR2wk4erBWcx6RX5TfxjnbjgJ76EdfD4U4MTHCYiX5MJTMwBtfoaq3q3p6001HiVFnNR"
              token={handleToken,submit}
              label="Commander"
              currency="EUR"
              amount={totalPrice * 100}
              >
                  <button className="btn">Commander</button>
              </StripeCheckout>
              
    const bouttonconnecter = <div>
        <p>Veuillez vous connecter pour commander</p>
        <a href="/login"><button className="btn">Se connecter</button></a>
        </div>

      

    return <aside className="block col-1">
        <h2>Cart Items</h2>
        <div>{cartItems.length === 0 && <div>Cart is Empty</div>}</div>
        {cartItems.map((item) => (
            <form key={item.name} className="row" action="" method="post">
            <div key={item.id} className="width">
                
                    <div className="itemName">
                    <input type="hidden" name="ProductName" id="ProductName" value={item.name} readOnly={true}/>
                    <input type="hidden" name="ProductQuantity" id="ProductQuantity" value={item.qty} readOnly={true}/>
                    <input type="hidden" name="ProductPrice" id="ProductPrice" value={item.price.toFixed(2)} readOnly={true}/>
                    </div>
                <div className="col-2">
                    <div className="row space-between">
                        <p>{item.name}</p>
                        <p>{item.qty} x {item.price.toFixed(2)} €</p>
                    </div>
                </div>
                <div className="row">
                    <div className="col-2">
                        <button type="button" onClick={() => onAdd(item)} className="btn add">+</button>
                        <button type="button" onClick={() => onRemove(item)} className="btn remove">-</button>
                    </div>
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
                {loggedIn ? bouttonpaiement : bouttonconnecter}
            </>
        )}
    </aside>
}