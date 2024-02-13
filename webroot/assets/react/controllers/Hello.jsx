import React, { useState } from 'react';

export default function Hello(props) {
  const [name, setName] = useState(props.fullName);
  return <div>Hello {name}</div>;
}
