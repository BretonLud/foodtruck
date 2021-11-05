import React, {useEffect, useState} from "react";
import StripeCheckout from "react-stripe-checkout";
import Header from "./Header";
import axios from "axios";




    
export default function Basket(props) {
    const {cartItems, onAdd, onRemove, loggedIn, sessionMail} = props
    const itemsPrice = cartItems.reduce((a, c) => a + c.price * c.qty, 0)
    //const taxPrice = itemsPrice * 0.10
    //const shippingPrice = itemsPrice > 20 ? 0 : 3
    const totalPrice = itemsPrice// + taxPrice + shippingPrice


    /** Requête Ajaw paiement**/
    const submit = (token) => {
        axios({
          method: 'POST',
          url: '/order/paiement',
          headers: {
            'Content-Type': 'application/json',
          },
          data: {

              Produits: JSON.stringify(cartItems, ['id', 'qty']),
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

      /** Bouton paiement**/
      const bouttonpaiement = <StripeCheckout 
              stripeKey="pk_test_51JjKjDCNkH9r21wgmurnRnbIkLFboSYR2wk4erBWcx6RX5TfxjnbjgJ76EdfD4U4MTHCYiX5MJTMwBtfoaq3q3p6001HiVFnNR"
              token={submit}
              locale="fr"
              email={sessionMail}
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

      

    return <aside id="panier" className="block col-1">
        <Header countCartItems={cartItems.length}/>
        {loggedIn ?<div>{cartItems.length === 0 && <div>Le panier est vide</div>}</div> : <div>{bouttonconnecter}</div> } {/* si panier vide */}
            {cartItems.map((item) => (
                <form key={item.name} className="row" action="" method="post">
                <div key={item.id} className="width">
                    
                        <div className="itemName">
                        <input type="hidden" name="ProductName" id="ProductName" value={item.name} readOnly={true}/>
                        <input type="hidden" name="ProductQuantity" id="ProductQuantity" value={item.qty} readOnly={true}/>
                        <input type="hidden" name="ProductPrice" id="ProductPrice" value={item.price.toFixed(2)} readOnly={true}/>
                        </div>
                    <div className="col-4">
                        <div className="row space-between">
                            <p className="produitpanier">{item.name}</p>
                            <p>{item.qty} x {item.price} €</p>
                        </div>
                        
                    </div>
                    <div className="row">
                        <div className="qtyselect col-4">
                            <button type="button" onClick={() => onRemove(item)} className="btn remove">-</button>
                            <button type="button" onClick={() => onAdd(item)} className="btn add">+</button>
                        </div>
                    </div>
                </div>
                </form>
            ))}
            {cartItems.length !== 0 && (
                <>
                    <hr />
                    <div className="row">
                        <div className="col-4"><strong>Prix Total</strong></div>
                        <div className="col-1 text-right"><strong>€{totalPrice.toFixed(2)}</strong></div>
                    </div>
                    <hr />
                    {loggedIn ? bouttonpaiement : bouttonconnecter}
                </>
            )}
    </aside>
}