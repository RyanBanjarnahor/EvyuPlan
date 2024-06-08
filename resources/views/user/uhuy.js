db.createCollection("categories", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            required: ["cate_id", "cate_descrip"],
            properties: {
                cate_id: { bsonType: "string" },
                cate_descrip: { bsonType: "string" },
            },
        },
    },
});

db.categories.insertMany([
    { cate_id: "CA001", cate_descrip: "Sains" },
    { cate_id: "CA002", cate_descrip: "Technology" },
    { cate_id: "CA003", cate_descrip: "Computers" },
    { cate_id: "CA004", cate_descrip: "Nature" },
    { cate_id: "CA005", cate_descrip: "Medical" },
]);

db.createCollection("books", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            required: [
                "book_id",
                "book_name",
                "isbn_no",
                "cate_id",
                "aut_id",
                "pub_id",
                "dt_of_pub",
                "pub_lang",
                "no_page",
                "book_price",
            ],
            properties: {
                book_id: { bsonType: "string" },
                book_name: { bsonType: "string" },
                isbn_no: { bsonType: "string" },
                cate_id: { bsonType: "string" },
                aut_id: { bsonType: "string" },
                pub_id: { bsonType: "string" },
                dt_of_pub: { bsonType: "date" },
                pub_lang: { bsonType: ["string", "null"] },
                no_page: { bsonType: "int", minimum: 0 },
                book_price: { bsonType: "decimal", minimum: 0 },
            },
        },
    },
});

db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $project: {
        cate_id: 1,
        cate_descrip: 1,
        total_books: { $size: '$books_in_category' }
      }
    }
  ])

  db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $unwind: '$books_in_category' // Untuk mengatasi multiple books dalam satu kategori
    },
    {
      $group: {
        _id: '$cate_id',
        cate_descrip: { $first: '$cate_descrip' },
        avg_rating: { $avg: '$books_in_category.rating' }
      }
    }
  ])

  db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $unwind: '$books_in_category' 
    },
    {
      $match: {
        'books_in_category.rating': { $gt: 4 }
      }
    },
    {
      $group: {
        _id: '$cate_id',
        cate_descrip: { $first: '$cate_descrip' },
        total_books_above_4_rating: { $sum: 1 }
      }
    }
  ])

  db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $unwind: '$books_in_category' 
    },
    {
      $sort: {
        'books_in_category.dt_of_pub': 1 
      }
    },
    {
      $group: {
        _id: '$cate_id',
        cate_descrip: { $first: '$cate_descrip' },
        oldest_book: { $first: '$books_in_category' }
      }
    },
    {
      $project: {
        _id: 0, 
        cate_id: '$_id',
        cate_descrip: 1,
        oldest_book: 1
      }
    }
  ])

  db.category.aggregate([
  {
    $lookup: {
      from: 'books',
      localField: 'cate_id',
      foreignField: 'cate_id',
      as: 'books_in_category'
    }
  },
  {
    $unwind: '$books_in_category' // Untuk mengatasi multiple books dalam satu kategori
  },
  {
    $group: {
      _id: '$cate_id',
      cate_descrip: { $first: '$cate_descrip' },
      total_pages: { $sum: '$books_in_category.no_page' }
    }
  },
  {
    $project: {
      _id: 0, // Tidak menampilkan _id
      cate_id: '$_id',
      cate_descrip: 1,
      total_pages: 1
    }
  }
])



db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $unwind: '$books_in_category' 
    },
    {
      $group: {
        _id: '$cate_id',
        cate_descrip: { $first: '$cate_descrip' },
        total_pages: { $sum: '$books_in_category.no_page' }
      }
    },
    {
      $project: {
        _id: 0, 
        cate_id: '$_id',
        cate_descrip: 1,
        total_pages: 1
      }
    }
  ])

  db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $unwind: '$books_in_category'
    },
    {
      $group: {
        _id: '$cate_id',
        cate_descrip: { $first: '$cate_descrip' },
        total_books: { $sum: 1 }
      }
    },
    {
      $sort: {
        total_books: -1
      }
    },
    {
      $limit: 1
    },
    {
      $project: {
        _id: 0, 
        cate_id: '$_id',
        cate_descrip: 1,
        total_books: 1
      }
    }
  ])

  db.categories.aggregate([
    {
      $match: {
        cate_descrip: 'Medical'
      }
    },
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $unwind: '$books_in_category'
    },
    {
      $project: {
        _id: 0, 
        cate_id: 1,
        cate_descrip: 1,
        book_id: '$books_in_category.book_id',
        book_name: '$books_in_category.book_name',
        isbn_no: '$books_in_category.isbn_no',        
      }
    }
  ])

  db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_category'
      }
    },
    {
      $unwind: '$books_in_category'
    },
    {
      $group: {
        _id: '$cate_id',
        cate_descrip: { $first: '$cate_descrip' },
        avg_pages: { $avg: '$books_in_category.no_page' }
      }
    },
    {
      $project: {
        _id: 0, 
        cate_id: '$_id',
        cate_descrip: 1,
        avg_pages: 1
      }
    }
  ])

  db.categories.aggregate([
    {
      $lookup: {
        from: 'books',
        localField: 'cate_id',
        foreignField: 'cate_id',
        as: 'books_in_categories'
      }
    },
    {
      $match: {
        books_in_category: { $size: 0 }
      }
    },
    {
      $project: {
        _id: 0, // Tidak menampilkan _id
        cate_id: 1,
        cate_descrip: 1
      }
    }
  ])

