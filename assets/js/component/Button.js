import React from 'react';

/** Bouton catégorie **/
function Button({button, filter}) {
    return ( 
        <div className="buttons">
            {
                button.map((cat, i)=>{
                    return <button key={i} className="btn btn-category" type="button" onClick={() => filter(cat)}>{cat}</button>
                })
            }
        </div>
     );
}

export default Button;