<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .card h2 {
            margin-top: 0;
        }
        .card .price, .card .date {
            color: #888;
        }
        .card button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .card button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Items List</h1>
    <button id="loadItems">Load Items</button>
    <ul id="eventsList"></ul>

    <form action="{{ route('payment.callback') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>

    <button id="rzp-button">Pay with Razorpay</button>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('loadItems').addEventListener('click', () => {
                fetch('http://127.0.0.1:8000/api/events', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNjhjNWE2NjRlNTUxOTg5ZDc1MDU1ODhkYTkyZTE5OWZmMDZlMTkyYjYwODRjOTcwZDVmZWM4YTUwNDkxYTUzOGFkOTZjOWVlNjk0NTJlN2UiLCJpYXQiOjE3MjExOTY0OTIuMjg0MDEyLCJuYmYiOjE3MjExOTY0OTIuMjg0MDE2LCJleHAiOjE3NTI3MzI0OTIuMjAzMjkyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.rs5827aIjaFi2hXtfyy_fFnO3R8FPmdmBEloi1Mcz-75JECk676UjhHaV3pibXJ5Gm2eplybf7xpTe2nBgfC93LA0RVgmw3qlPOkPZUEHjYY_3tFtpUiX00GG5m4vRNHMrksY21xJfMigjRdHtedfrupgoAG1_ydCv7j5vgw9aIOXHC3LhKb9ymCMqltz05mEN-GfOatKaNUz0dY1gLhM9zJpQwsTNKUDcOP2CDzrPcB_j-EN3jOwL9AmXQlgAGYtB78jx4yk_ku5021tx6_3rDx8srKMIELaKANgxCygw9myd3cagypnJUZtSOO7KzxySkO1rA2iycSqlLkT50AJFyLjG3YdJm42OTX9F44ofueuKiUf51hYZCH6p0g9oPJ1__cF5RSyO7rDYsvTn9q00qjqPHX7Y0CKpkMZjN83p9osFSY6dRv-JLPFPXGgmf6JREyw44f59JrS_nybwZLeijjd9YRmQAcCZWcTwWB-q2M1MFwhQiiq5zIgjdHQVxf02LLA7dTXowZmuFNIyZVbkWMOEvxzRWACRdGyZ_9Zi_-ov7m9XATXya9sNkbc_3gIVkUko3LoQ50RuxybVvcOrW0CY08PXYpvKeZ94khDACX94IdnnUzP3Mo1GrCJlGv8Hr6e3MLEbQssoEg6UAb33sLuNusB93LavBcqXcpy1s'
                    },
                })
                    .then(response => response.json())
                       .then(data => {
                        console.log(data.data)
                        data.data.forEach(element => {
                            const card = document.createElement('div');
                            card.classList.add('card');
                            
                            const title = document.createElement('h2');
                            title.textContent = element.title;
                            
                            const price = document.createElement('p');
                            price.classList.add('price');
                            price.textContent = 'Price: $' + element.price;
                            
                            const date = document.createElement('p');
                            date.classList.add('date');
                            date.textContent = 'Date: ' + element.date;
                            
                            const button = document.createElement('button');
                            button.textContent = 'Book Ticket';
                            button.addEventListener('click', () => {
                                bookTicket(element.id);
                            });
                            
                            card.appendChild(title);
                            card.appendChild(price);
                            card.appendChild(date);
                            card.appendChild(button);
                            
                            eventsList.appendChild(card);
                        });
                        
                     }
                    )
                    .catch(error => console.error('Error:', error));
            });
        });

        function bookTicket(id) {
            fetch('http://127.0.0.1:8000/api/tickets', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNjhjNWE2NjRlNTUxOTg5ZDc1MDU1ODhkYTkyZTE5OWZmMDZlMTkyYjYwODRjOTcwZDVmZWM4YTUwNDkxYTUzOGFkOTZjOWVlNjk0NTJlN2UiLCJpYXQiOjE3MjExOTY0OTIuMjg0MDEyLCJuYmYiOjE3MjExOTY0OTIuMjg0MDE2LCJleHAiOjE3NTI3MzI0OTIuMjAzMjkyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.rs5827aIjaFi2hXtfyy_fFnO3R8FPmdmBEloi1Mcz-75JECk676UjhHaV3pibXJ5Gm2eplybf7xpTe2nBgfC93LA0RVgmw3qlPOkPZUEHjYY_3tFtpUiX00GG5m4vRNHMrksY21xJfMigjRdHtedfrupgoAG1_ydCv7j5vgw9aIOXHC3LhKb9ymCMqltz05mEN-GfOatKaNUz0dY1gLhM9zJpQwsTNKUDcOP2CDzrPcB_j-EN3jOwL9AmXQlgAGYtB78jx4yk_ku5021tx6_3rDx8srKMIELaKANgxCygw9myd3cagypnJUZtSOO7KzxySkO1rA2iycSqlLkT50AJFyLjG3YdJm42OTX9F44ofueuKiUf51hYZCH6p0g9oPJ1__cF5RSyO7rDYsvTn9q00qjqPHX7Y0CKpkMZjN83p9osFSY6dRv-JLPFPXGgmf6JREyw44f59JrS_nybwZLeijjd9YRmQAcCZWcTwWB-q2M1MFwhQiiq5zIgjdHQVxf02LLA7dTXowZmuFNIyZVbkWMOEvxzRWACRdGyZ_9Zi_-ov7m9XATXya9sNkbc_3gIVkUko3LoQ50RuxybVvcOrW0CY08PXYpvKeZ94khDACX94IdnnUzP3Mo1GrCJlGv8Hr6e3MLEbQssoEg6UAb33sLuNusB93LavBcqXcpy1s'

                },
                body: JSON.stringify({
                    event_id: id
                }),
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    razorpayPayment(data);
                    
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function razorpayPayment(data) {
            const options = {
            "key": "rzp_test_Y3BabS2kuePGlC",
            "amount": data.event.price, // Amount in paisa
            "currency": "INR",
            "order_id": data.order_id,
            "handler": function (response) {
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.getElementById('payment-form').submit();
            }
        };

        const rzp1 = new Razorpay(options);
        
        document.getElementById('rzp-button').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        }
        }
    </script>
</body>
</html>
