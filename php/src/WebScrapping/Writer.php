<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * Save data into a xlsx file.
 */
class Writer{

    /**
     * write the given data in the given path as a xlsx file
     */
    public function write_xlsx($data, $path): void {
        $data = $this->format_data($data);
        
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($path);

        foreach($data as $data_row){
            $row = WriterEntityFactory::createRowFromArray($data_row);
            $writer->addRow($row);
        }

        $writer->close();
    }

    public function format_data($data): array{
        $formated_data = [];
        $formated_data[] = ['id', 'title', 'type', 'author 1', 'author 1 institution', 'author 2', 'author 2 institution', 'author 3', 'author 3 institution', 'author 4', 'author 4 institution', 'author 5', 'author 5 institution', 'author 6', 'author 6 institution', 'author 7', 'author 7 institution', 'author 8', 'author 8 institution', 'author 9', 'author 9 institution'];

        foreach ($data as $paper) {
            $formated_paper = [
                $paper->id,
                $paper->title,
                $paper->type,
            ];

            foreach ($paper->authors as $author) {
                $formated_paper[] = $author->name;
                $formated_paper[] = $author->institution;
            }

            $formated_data[] = $formated_paper;
        }
        return $formated_data;

    }
}
