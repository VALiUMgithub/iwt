const apiKey = "AIzaSyCBJ9SgQfRv40nRBOZKKFERZCWnV68iaj0"; // Get your API key from Google Books

const bookInput = document.querySelector("#book-input");
const searchBooksButton = document.querySelector("#search-books");
const bookResultsDiv = document.querySelector("#book-results");

searchBooksButton.addEventListener("click", async () => {
  const bookTitle = bookInput.value;

  const response = await fetch(
    `https://www.googleapis.com/books/v1/volumes?q=${bookTitle}&key=${apiKey}`
  );

  const bookData = await response.json();

  const books = bookData.items;

  bookResultsDiv.innerHTML = "";

  for (const book of books) {
    const bookResultElement = document.createElement("div");
    bookResultElement.classList.add("book-result");

    const bookImageElement = document.createElement("img");
    bookImageElement.src = book.volumeInfo.imageLinks.thumbnail;
    bookResultElement.appendChild(bookImageElement);

    const bookTitleElement = document.createElement("h2");
    bookTitleElement.innerHTML = book.volumeInfo.title;
    bookResultElement.appendChild(bookTitleElement);

    const bookLinkElement = document.createElement("a");
    bookLinkElement.href = book.volumeInfo.infoLink;
    bookLinkElement.innerHTML = "Download";
    bookResultElement.appendChild(bookLinkElement);

    bookResultsDiv.appendChild(bookResultElement);
  }
});
