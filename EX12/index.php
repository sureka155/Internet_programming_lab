<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Inventory Management</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f2f5; margin: 0; padding: 40px 20px; color: #333; }
        .container { max-width: 1000px; margin: auto; }
        h1 { margin-bottom: 5px; color: #1e293b; }
        .subtitle { color: #64748b; margin-bottom: 30px; font-size: 1.1rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(450px, 1fr)); gap: 20px; }
        @media(max-width: 600px) { .grid { grid-template-columns: 1fr; } }
        .book-card { background: #ffffff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between; }
        .book-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .book-title { margin: 0; font-size: 1.3rem; color: #0f172a; font-weight: 600; line-height: 1.3; }
        .genre-badge { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; margin-left: 10px; }
        .book-meta { font-size: 0.9rem; color: #475569; margin: 6px 0; }
        .book-desc { font-size: 0.95rem; color: #334155; margin-top: 14px; border-top: 1px dashed #e2e8f0; padding-top: 14px; line-height: 1.5; }
        .price-tag { font-weight: bold; color: #16a34a; font-size: 1.1rem; }
        .error { color: #dc2626; background: #fee2e2; padding: 15px; border-radius: 8px; border: 1px solid #fca5a5; font-weight: 500; }
    </style>
</head>
<body>
<div class="container">
    
    <?php
    $filename = "books.xml";

    if (file_exists($filename)) {
        $xml = simplexml_load_file($filename);

        if ($xml) {
            $totalBooks = count($xml->book);
            echo "<h1>Book Catalog</h1>";
            echo "<p class='subtitle'>Displaying <strong>{$totalBooks}</strong> active inventory items records.</p>";
            echo "<div class='grid'>";

            foreach ($xml->book as $book) {
                // Secure and process data attributes
                $id = htmlspecialchars((string)$book['id'], ENT_QUOTES, 'UTF-8');
                $title = htmlspecialchars((string)$book->title, ENT_QUOTES, 'UTF-8');
                $author = htmlspecialchars((string)$book->author, ENT_QUOTES, 'UTF-8');
                $genre = htmlspecialchars((string)$book->genre, ENT_QUOTES, 'UTF-8');
                $price = htmlspecialchars((string)$book->price, ENT_QUOTES, 'UTF-8');
                $currency = htmlspecialchars((string)$book->price['currency'], ENT_QUOTES, 'UTF-8');
                $date = htmlspecialchars((string)$book->publish_date, ENT_QUOTES, 'UTF-8');
                // Format the output date nicely
                $formattedDate = date("M d, Y", strtotime($date));
                $desc = htmlspecialchars((string)$book->description, ENT_QUOTES, 'UTF-8');

                echo "<div class='book-card'>";
                echo "  <div>";
                echo "    <div class='book-header'>";
                echo "      <h2 class='book-title'>{$title}</h2>";
                echo "      <span class='genre-badge'>{$genre}</span>";
                echo "    </div>";
                echo "    <div class='book-meta'><strong>Author:</strong> {$author}</div>";
                echo "    <div class='book-meta'><strong>Published:</strong> {$formattedDate}</div>";
                echo "    <div class='book-meta'><strong>Price:</strong> <span class='price-tag'>{$price} {$currency}</span></div>";
                echo "  </div>";
                echo "  <div class='book-desc'>{$desc}</div>";
                echo "</div>";
            }
            
            echo "</div>"; // End grid
        } else {
            echo "<p class='error'>Critical Error: Failed to parse XML markup structure.</p>";
        }
    } else {
        echo "<p class='error'>Critical Error: Target file source '{$filename}' could not be located.</p>";
    }
    ?>
</div>
</body>
</html>
