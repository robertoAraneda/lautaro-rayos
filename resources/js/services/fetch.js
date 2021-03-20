var myHeaders = new Headers();
myHeaders.append('Content-Type', 'application/json');
myHeaders.append(
    'Authorization',
    `Bearer ${localStorage.getItem('access_token')}`
);

export default myHeaders;
