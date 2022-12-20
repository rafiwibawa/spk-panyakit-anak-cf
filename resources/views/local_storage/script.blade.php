{{-- local_storage.script --}}

<script>
    const getItems = (name, defaultValue) => {
        let items = defaultValue;
        const localCart = localStorage.getItem(name);

        if (localCart !== null) {
            items = JSON.parse(localCart);
        }

        return items;
    };

    const setItems = (name, items) => {
        localStorage.setItem(name, JSON.stringify(items));
    };

    const removeItems = (name) => {
        localStorage.removeItem(name);
    };

    const addItem = (name, item) => {
        setItems(name, [...getItems(name), item]);
    };

    const updateItem = (name, item) => {
        setItems(name, getItems(name).map(i => {
            if (i.id === item.id) return item;
            return i;
        }));
    };

    const deleteItem = (name, item) => {
        setItems(name, getItems(name).filter(i => i.id !== item.id));
    };
   
</script>