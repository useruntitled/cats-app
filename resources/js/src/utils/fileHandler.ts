export const fileHandler = {
    handle: (file: File, callback: Function) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            return callback(reader.result as string);
        };
    },
};
