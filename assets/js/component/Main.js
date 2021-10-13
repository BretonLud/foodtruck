import React from "react";
import Product from "./Product";

export default function Main(props) {
const {onAdd, menuItem, products} = props

    return <main className="block col-2">
        <h2>Products</h2>
        <div>
                <Product  menuItem={menuItem} onAdd={onAdd} products={products}></Product>
        </div>
    </main>
}