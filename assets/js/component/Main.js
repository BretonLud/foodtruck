import React from "react";
import Product from "./Product";

/** Affichage fenêtre principal avec liste produit**/
export default function Main(props) {
const {onAdd, menuItem, products} = props

    return <main className="block col-4">
        <h2>Produits</h2>
        <div>
                <Product  menuItem={menuItem} onAdd={onAdd} products={products}></Product>
        </div>
    </main>
}