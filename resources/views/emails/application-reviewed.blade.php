<!DOCTYPE html>
<html lang="mk">

<head>
	<meta charset="UTF-8">
	<title>Пријава прегледана</title>
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

		.status-approved {
			color: #28a745;
			font-weight: bold;
		}

		.status-rejected {
			color: #dc3545;
			font-weight: bold;
		}

		.admin-msg {
			background: #f8f9fa;
			border-left: 4px solid #3A6FD8;
			padding: 1rem;
			border-radius: 4px;
			margin: 1rem 0;
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
		<h2>
			Статус на пријавата:
			@if($application->status === 'approved')
			<span class="status-approved">Одобрена ✅</span>
			@else
			<span class="status-rejected">Одбиена ❌</span>
			@endif
		</h2>
		<p>Почитуван/а {{ $application->name }} {{ $application->surname }},</p>
		<p>
			@if($application->status === 'approved')
			Со задоволство ве информираме дека вашата пријава е <strong>одобрена</strong>.
			Добредојде во тимот!
			@else
			За жал, вашата пријава не е одобрена за оваа година. Ве охрабруваме да се пријавите
			повторно во следниот циклус.
			@endif
		</p>
		@if($application->admin_response)
		<div class="admin-msg">
			<strong>Порака од организаторите:</strong><br>
			{{ $application->admin_response }}
		</div>
		@endif
		<p>Со почит,<br>Тимот на Еволуција на Сонот</p>
		<div class="footer">evolucijanasonot@gmail.com</div>
	</div>
</body>

</html>