<!DOCTYPE html>
<html lang="mk">

<head>
	<meta charset="UTF-8">
	<title>Пријавата е примена</title>
	<style>
		body {
			font-family: 'Arial', sans-serif;
			background: #f5f0e8;
			color: #2c2c2c;
			margin: 0;
			padding: 20px;
		}

		.email-card {
			background: #fff;
			border-radius: 12px;
			max-width: 540px;
			margin: 0 auto;
			padding: 2rem;
		}

		h1 {
			color: #3A6FD8;
			font-size: 1.4rem;
		}

		.footer {
			margin-top: 2rem;
			font-size: 0.8rem;
			color: #999;
			border-top: 1px solid #eee;
			padding-top: 1rem;
		}
	</style>
</head>

<body>
	<div class="email-card">
		<h1>Еволуција на Сонот</h1>
		<h2>Пријавата е примена! ✅</h2>
		<p>Почитуван/а {{ $application->name }} {{ $application->surname }},</p>
		<p>Ве информираме дека вашата пријава е успешно примена. Нашиот тим ќе ја прегледа и ќе ве контактира.</p>
		<p>Детали:</p>
		<ul>
			<li><strong>Е-пошта:</strong> {{ $application->email }}</li>
			<li><strong>Област:</strong> {{ $application->collaboration_area }}</li>
			<li><strong>Година:</strong> {{ $application->year }}</li>
		</ul>
		<p>Со почит,<br>Тимот на Еволуција на Сонот</p>
		<div class="footer">evolucijanasonot@gmail.com</div>
	</div>
</body>

</html>