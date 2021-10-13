import burger1 from './img/burger1.jpg';
import burger2 from './img/burger2.webp';
import salade1 from './img/salade1.jpeg';
import salade2 from './img/salade2.jpg';
import wrap from './img/wrap.jpg';
import sprite from './img/sprite.jpg';
import coca from './img/coca-cola.png';

const data = {
    products: [
        {
            id: '1',
            name: 'Burger',
            category: 'Burger',
            category2: 'Végétarien',
            description: 'Burger excellent',
            price: 5,
            image: burger1,
        },
        {
            id: '2',
            name: 'Burger +',
            category: 'Burger',
            category2: 'Boeuf',
            description: 'Burger excellent plus gros',
            price: 6,
            image: burger2,
        },
        {
            id: '3',
            name: 'Salade',
            category: 'Salade',
            category2: 'Végétarien',
            description: 'Salade excellente',
            price: 4,
            image: salade1,
        },
        {
            id: '4',
            name: 'Salade n°2',
            category: 'Salade',
            category2: 'Végétarien',
            description: 'Salade excellente aussi',
            price: 5,
            image: salade2,
        },
        {
            id: '5',
            name: 'Wrap',
            category: 'Wrap',
            category2: 'Poulet',
            description: 'Très bon Wrap',
            price: 3,
            image: wrap,
        },
        {
            id: '6',
            name: 'Sprite',
            category: 'Boisson',
            category2: '',
            description: 'Boisson rafraichissante',
            price: 4,
            image: sprite,
        },
        {
            id: '7',
            name: 'Coca-Cola',
            category: 'Boisson',
            category2: '',
            description: 'Pepsi moins bon',
            price: 4,
            image: coca,
        },
        {
            id: '8',
            name: 'Maxi Burger',
            category: 'Burger',
            category2: 'Boeuf',
            description: 'Le plus GROS burger',
            price: 8,
            image: burger2,
        },
    ],
};

export default data;