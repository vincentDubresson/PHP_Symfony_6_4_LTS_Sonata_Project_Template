import React, {useState} from 'react';

export default function (props) {
    const [name, setName] = useState(props.fullName);
    return <div className="mx-auto mt-5 max-w-xl text-xl text-gray-500">Hello {name}</div>;
}
