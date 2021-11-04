//import './App.css';
import React from 'react';
import { useState } from 'react';
import Header from './component/Header';
import Main from './component/Main';
import Basket from './component/Basket';
import Button from './component/Button';

function App(props) {
  const {itemOptions, loggedIn, sessionMail} = props //Récupère kes produits de la BdD, Si l'utilisateur est connecté et son mail s'il l'est
  const stock = itemOptions.stock //Récupère si les produits sont en stock
  const products = itemOptions
  const [cartItems, setCartItems] = useState([])
  const onAdd = (product) => {
    const exist = cartItems.find(x => x.id === product.id)
    if(exist) {
      setCartItems(cartItems.map(x => x.id === product.id ? {...exist, qty: exist.qty + 1} : x ))
    } else {
      setCartItems([...cartItems, {...product, qty: 1}])
    }
  }

  const onRemove = (product) => {
    const exist = cartItems.find((x) => x.id === product.id)
    if(exist.qty === 1) {
      setCartItems(cartItems.filter((x) => x.id !== product.id))
    } else {
      setCartItems(cartItems.map(x => x.id === product.id ? {...exist, qty: exist.qty - 1} : x ))
    }
  }


  /** Filtre **/
let cat = [...new Set(products.map(product => product.category))] //Suppression des doublons si plusieurs produits on la même catégorie
let tab = []

cat.forEach(category => tab.push(...category))
const categories = ['Tout', ...new Set(tab)]

const allCategories = categories.filter(categories => categories !== undefined) //Ne pas afficher de bouton vide en cas de catégorie non définie lorsque les produit n'ont qu'une catégorie

const [menuItem, setMenuItem] = useState(products);

const [buttons] = useState(allCategories);


    const filter = (button) => {
        /** Bouton 'tout' affiche tous les produits **/
        if (button === 'Tout') {
            setMenuItem(products)
            return
        } 

        /** Le bouton filtre les produits correspondant au bouton**/
        const filter1 = products.filter(function(product) {
          if (product.category.includes(button)) {
            return true
          }
          return false
        })

        
        const filteredData = filter1 

        setMenuItem(filteredData)

    }

  return (
    <div className="App">
      <div className="row">
        <div className="col-4">
          <Button button={buttons} filter={filter}/>
          <Main menuItem={menuItem}onAdd={onAdd} products={products}></Main>
        </div>
        <div className="col-1">
          <Basket onAdd={onAdd} onRemove={onRemove} cartItems={cartItems} loggedIn={loggedIn} sessionMail={sessionMail}></Basket>
        </div>
      </div>
    </div>
  );
}
export default App;
