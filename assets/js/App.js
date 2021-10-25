//import './App.css';
import React from 'react';
import { useState } from 'react';
import Header from './component/Header';
import Main from './component/Main';
import Basket from './component/Basket';
import Button from './component/Button';

function App(props) {
  const {itemOptions, loggedIn, sessionMail} = props
  const stock = itemOptions.stock
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

// filtre 


let cat = [...new Set(products.map(product => product.category))]
let tab = []

cat.forEach(category => tab.push(...category))
const categories = ['All', ...new Set(tab)]

const allCategories = categories.filter(categories => categories !== undefined)

const [menuItem, setMenuItem] = useState(products);



const [buttons] = useState(allCategories);


    const filter = (button) => {

        if (button === 'All') {
            setMenuItem(products)
            return
        } 


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
