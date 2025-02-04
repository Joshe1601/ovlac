{{--{{ dd('lo que llega al pdf sobre el logo path', $logo_path) }}--}}
<html>
	<head>
		<meta charset="utf-8">
		<title>{{ tra('Budget') }}</title>
        <style>
            * {
                border: 0;
                box-sizing: content-box;
                color: inherit;
                font-family: inherit;
                font-size: inherit;
                font-style: inherit;
                font-weight: inherit;
                line-height: inherit;
                list-style: none;
                margin: 0;
                padding: 0;
                text-decoration: none;
                vertical-align: top;
            }

            /* content editable */

            *[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }

            *[contenteditable] { cursor: pointer; }

            *[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable],
            td:focus *[contenteditable], img.hover {
                background: #DEF;
                box-shadow: 0 0 1em 0.5em #DEF;
            }

            span[contenteditable] { display: inline-block; }

            /* heading */

            h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

            /* table */

            table { font-size: 75%; table-layout: fixed; width: 100%; }
            table { border-collapse: separate; border-spacing: 2px; }
            th, td { border-width: 0px; padding: 0.5em; position: relative; text-align: left; }
            th, td { border-radius: 0.25em; border-style: solid; }
            th { background: #d9d8d8; border-color: #DDD; }
            td { border-color: #DDD; }
            .price {
                text-align: right;
            }

            td > span {display: inline;}

            /* page */

            html { font: 18px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
            html { background: #d8d7d7; cursor: default; }

            body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; /* width: 8.5in; */ }
            body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

            /* header */

            header { margin: 0 0 3em; }
            header:after { clear: both; content: ""; display: table; }

            header h1 { background: #e52b38; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
            header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
            header address p { margin: 0 0 0.25em; }
            header span, header img { display: block; float: right; }
            header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
            header img {
                max-height: 100%;
                max-width: 100%;
                text-align: left;
            }

            header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

            /* article */

            article, article address, table.meta, table.inventory { margin: 0 0 3em; }
            article:after { clear: both; content: ""; display: table; }
            article h1 { clip: rect(0 0 0 0); position: absolute; }

            article address { float: left; font-size: 125%; font-weight: bold; }

            /* table meta & balance */

            table.meta, table.balance { float: right; width: 36%; }
            table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

            /* table meta */

            table.meta th { width: 40%; }
            table.meta td { width: 60%; }

            /* table items */

            table.inventory { clear: both; width: 100%; }
            table.inventory th { font-weight: bold; text-align: center; }

            table.inventory td:nth-child(1) { width: 40%; }
            table.inventory td:nth-child(2) { width: 20%; }
            table.inventory td:nth-child(3) { text-align: right; width: 12%; }
            table.inventory td:nth-child(4) { text-align: right; width: 12%; }
            table.inventory td:nth-child(5) { text-align: right; width: 12%; }

            /* table balance */

            table.balance th, table.balance td { width: 50%; }
            table.balance td { text-align: right; }

            /* aside */

            aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
            aside h1 { border-color: #999; border-bottom-style: solid; }

            /* javascript */

            .add, .cut
            {
                border-width: 1px;
                display: block;
                font-size: .8rem;
                padding: 0.25em 0.5em;
                float: left;
                text-align: center;
                width: 0.6em;
            }

            .add, .cut
            {
                background: #9AF;
                box-shadow: 0 1px 2px rgba(0,0,0,0.2);
                background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
                background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
                border-radius: 0.5em;
                border-color: #0076A3;
                color: #FFF;
                cursor: pointer;
                font-weight: bold;
                text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
            }

            .add { margin: -2.5em 0 0; }

            .add:hover { background: #00ADEE; }

            .cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
            .cut { -webkit-transition: opacity 100ms ease-in; }

            tr:hover .cut { opacity: 1; }

            @media print {
                * { -webkit-print-color-adjust: exact; }
                html { background: none; padding: 0; }
                body { box-shadow: none; margin: 0; }
                span:empty { display: none; }
                .add, .cut { display: none; }
            }

            @page { margin: 0; }

            .screenshot {
                width: 65%;
                margin: 0 auto;
                max-height: 500px;
                overflow: hidden;
            }

            .screenshot img {
                width: 100%;
                height: auto;
                object-fit: cover;
                display: block;
                margin: 0 auto;
            }

            .footer {
                position: absolute;
                background-color: #e52b38;
                bottom:0;
                width: 87%;
                text-align: center;
                padding: 20px 10px;
                color: white;
                font-size: 14px;
                margin: 0 auto;
                margin-right: 40px;
                border-top-left-radius: 0.25em;
                border-top-right-radius: 0.25em;

            }
            .footer p {
                margin: 4px auto;
            }
        </style>
	</head>
	<body>

		<header>
            <h1>{{ $product->title }}</h1>
            @if(isset($relative_path))
                <img src="{{ $relative_path . "/public/images/ovlac/logo_ovlac_fondo_blanco.jpg" }}" alt="" width="200px">
            @endif

		</header>
		<article>
			<address contenteditable>
				<h2>{{ tra("Products") }}</h2>
			</address>

			<table class="inventory">
				<thead>
					<tr>
						<th><span contenteditable>{{ tra("Product") }}</span></th>
						<th><span contenteditable>{{ tra("Price") }}</span></th>
					</tr>
				</thead>
				<tbody>
                    <tr>
                        <td><span>{{ tra("Base Price") }}</span></td>
                        <td class="price"><span>{{ number_format($product->price, 2) }} €</span></td>
                    </tr>
                    @foreach ($product_parts as $part)
                        <tr>
                            <td><span>{{ $part->title_full() }}</span></td>
                            <td class="price"><span>{{ number_format($part->price_full(), 2) }} €</span></td>
                        </tr>
                    @endforeach
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span contenteditable>{{ tra("Total") }}</span></th>
					<td><span>{{ number_format($total_price, 2) }} €</span></td>
				</tr>
			</table>
		</article>
		 <aside>
             {{-- Include the screenshot --}}
             @if(isset($screenshot_path))
                 <div class="screenshot">
                     <img src="{{ $screenshot_path }}" alt="Screenshot" class="screenshot">
                 </div>
             @endif
		</aside>
        <footer class="footer">
            <p>Email: ovlac@ovlac.com</p>
            <p>Phone: +34 979 761 011</p>
            <p>
                Address: Pol. Ind. Venta de Baños Parcela 163 / 165
                34200 Venta de Baños (Palencia) España
            </p>
        </footer>
	</body>
</html>
