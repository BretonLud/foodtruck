import { useState } from 'react';

const useModal = () => {
  const [isShowing, setIsShowing] = useState(false);
  const [isProduct, setIsProduct,] = useState({});

  function toggle(e) {
    setIsShowing(!isShowing);
    setIsProduct(e);

  }

  return {
    isShowing,
    toggle,
    isProduct,

  }
};

export default useModal;