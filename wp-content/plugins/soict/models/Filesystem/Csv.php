<?php

namespace Soict\Model\Filesystem;

class Csv {

	/**
	 * @var int
	 */
	protected $_lineLength = 0;
	/**
	 * @var string
	 */
	protected $_delimiter = ',';
	/**
	 * @var string
	 */
	protected $_enclosure = '"';
	/**
	 * @var File
	 */
	protected $file;
	/**
	 * Constructor
	 *
	 * @param File $file File Driver used for writing CSV
	 */
	public function __construct()
	{

	}
	/**
	 * Set max file line length
	 *
	 * @param   int $length
	 * @return  \Magento\Framework\File\Csv
	 */
	public function setLineLength($length)
	{
		$this->_lineLength = $length;
		return $this;
	}
	/**
	 * Set CSV column delimiter
	 *
	 * @param   string $delimiter
	 * @return  \Magento\Framework\File\Csv
	 */
	public function setDelimiter($delimiter)
	{
		$this->_delimiter = $delimiter;
		return $this;
	}
	/**
	 * Set CSV column value enclosure
	 *
	 * @param   string $enclosure
	 * @return  \Magento\Framework\File\Csv
	 */
	public function setEnclosure($enclosure)
	{
		$this->_enclosure = $enclosure;
		return $this;
	}
	/**
	 * Retrieve CSV file data as array
	 *
	 * @param   string $file
	 * @return  array
	 * @throws \Exception
	 */
	public function getData($file)
	{
		$data = [];
		if (!file_exists($file)) {
			throw new \Exception('File "' . $file . '" does not exist');
		}
		$fh = fopen($file, 'r');
		while ($rowData = fgetcsv($fh, $this->_lineLength, $this->_delimiter, $this->_enclosure)) {
			$data[] = $rowData;
		}
		fclose($fh);
		return $data;
	}
	/**
	 * Retrieve CSV file data as pairs
	 *
	 * @param   string $file
	 * @param   int $keyIndex
	 * @param   int $valueIndex
	 * @return  array
	 */
	public function getDataPairs($file, $keyIndex = 0, $valueIndex = 1)
	{
		$data = [];
		$csvData = $this->getData($file);
		foreach ($csvData as $rowData) {
			if (isset($rowData[$keyIndex])) {
				$data[$rowData[$keyIndex]] = isset($rowData[$valueIndex]) ? $rowData[$valueIndex] : null;
			}
		}
		return $data;
	}
	/**
	 * Saving data row array into file
	 *
	 * @param   string $file
	 * @param   array $data
	 * @return  $this
	 */
	public function saveData($file, $data)
	{
		$fh = fopen($file, 'w');
		foreach ($data as $dataRow) {
			$this->filePutCsv($fh, $dataRow, $this->_delimiter, $this->_enclosure);
		}
		fclose($fh);
		return $this;
	}

	/**
	 * Writes one CSV row to the file.
	 *
	 * @param resource $resource
	 * @param array $data
	 * @param string $delimiter
	 * @param string $enclosure
	 * @return int
	 * @throws FileSystemException
	 */
	public function filePutCsv($resource, array $data, $delimiter = ',', $enclosure = '"')
	{
		/**
		 * Security enhancement for CSV data processing by Excel-like applications.
		 * @see https://bugzilla.mozilla.org/show_bug.cgi?id=1054702
		 *
		 * @var $value string|\Magento\Framework\Phrase
		 */
		foreach ($data as $key => $value) {
			if (!is_string($value)) {
				$value = (string)$value;
			}
			if (isset($value[0]) && in_array($value[0], ['=', '+', '-'])) {
				$data[$key] = ' ' . $value;
			}
		}
		$result = @fputcsv($resource, $data, $delimiter, $enclosure);
		if (!$result) {
			throw new \Exception('Error occurred during execution of filePutCsv %1');
		}
		return $result;
	}
}
